<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkerRequest;
use App\Http\Requests\UpdateWorkerRequest;
use App\Models\City;
use App\Models\SkillCategory;
use App\Models\SkillLevel;
use App\Models\Worker;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WorkerController extends Controller
{
    /**
     * Display a listing of available workers.
     */
    public function index(Request $request)
    {
        $query = Worker::with(['user.city', 'skillCategory', 'skillLevel'])
            ->available()
            ->certified();

        // Filter by skill category
        if ($request->filled('skill_category')) {
            $query->where('skill_category_id', $request->skill_category);
        }

        // Filter by city (location-based search)
        if ($request->filled('city_id')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('city_id', $request->city_id);
            });
        }

        // Sort by rating
        if ($request->filled('sort')) {
            if ($request->sort === 'rating') {
                $query->orderBy('rating', 'desc');
            } elseif ($request->sort === 'jobs') {
                $query->orderBy('total_jobs', 'desc');
            }
        }

        $workers = $query->paginate(12);
        $skillCategories = SkillCategory::all();
        $cities = City::all();

        return Inertia::render('workers/index', [
            'workers' => $workers,
            'skillCategories' => $skillCategories,
            'cities' => $cities,
            'filters' => $request->only(['skill_category', 'city_id', 'sort']),
        ]);
    }

    /**
     * Display the specified worker.
     */
    public function show(Worker $worker)
    {
        $worker->load([
            'user.city',
            'skillCategory',
            'skillLevel',
            'user.receivedReviews.reviewer',
            'jobRequests' => function ($query) {
                $query->completed()->latest()->take(5);
            }
        ]);

        return Inertia::render('workers/show', [
            'worker' => $worker,
        ]);
    }

    /**
     * Show the form for creating a new worker profile.
     */
    public function create()
    {
        $skillCategories = SkillCategory::all();
        $skillLevels = SkillLevel::all();
        $cities = City::all();

        return Inertia::render('workers/create', [
            'skillCategories' => $skillCategories,
            'skillLevels' => $skillLevels,
            'cities' => $cities,
        ]);
    }

    /**
     * Store a newly created worker profile.
     */
    public function store(StoreWorkerRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        
        // Update user role to worker
        auth()->user()->update(['role' => 'worker']);
        
        $worker = Worker::create($data);

        return redirect()->route('workers.show', $worker)
            ->with('success', 'Profil tukang berhasil dibuat. Silakan lengkapi data untuk proses sertifikasi.');
    }

    /**
     * Show the form for editing the worker profile.
     */
    public function edit(Worker $worker)
    {
        if (auth()->id() !== $worker->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $skillCategories = SkillCategory::all();
        $skillLevels = SkillLevel::all();
        $cities = City::all();

        return Inertia::render('workers/edit', [
            'worker' => $worker,
            'skillCategories' => $skillCategories,
            'skillLevels' => $skillLevels,
            'cities' => $cities,
        ]);
    }

    /**
     * Update the specified worker profile.
     */
    public function update(UpdateWorkerRequest $request, Worker $worker)
    {
        if (auth()->id() !== $worker->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $worker->update($request->validated());

        return redirect()->route('workers.show', $worker)
            ->with('success', 'Profil tukang berhasil diperbarui.');
    }

    /**
     * Remove the specified worker profile.
     */
    public function destroy(Worker $worker)
    {
        if (auth()->id() !== $worker->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $worker->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Profil tukang berhasil dihapus.');
    }
}