<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobRequestRequest;
use App\Http\Requests\UpdateJobRequestRequest;
use App\Models\City;
use App\Models\JobRequest;
use App\Models\SkillCategory;
use App\Models\Worker;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JobRequestController extends Controller
{
    /**
     * Display a listing of job requests.
     */
    public function index(Request $request)
    {
        $query = JobRequest::with(['user', 'skillCategory', 'city', 'worker.user']);

        // For workers: show available jobs
        if (auth()->user()->isWorker()) {
            $query->where(function ($q) {
                $q->where('status', 'open')
                  ->orWhere('worker_id', auth()->user()->worker->id);
            });
        } else {
            // For clients: show their own job requests
            $query->where('user_id', auth()->id());
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $jobRequests = $query->latest()->paginate(10);

        return Inertia::render('jobs/index', [
            'jobRequests' => $jobRequests,
            'filters' => $request->only(['status']),
        ]);
    }

    /**
     * Show the form for creating a new job request.
     */
    public function create()
    {
        $skillCategories = SkillCategory::all();
        $cities = City::all();

        return Inertia::render('jobs/create', [
            'skillCategories' => $skillCategories,
            'cities' => $cities,
        ]);
    }

    /**
     * Store a newly created job request.
     */
    public function store(StoreJobRequestRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $jobRequest = JobRequest::create($data);

        return redirect()->route('job-requests.show', $jobRequest)
            ->with('success', 'Permintaan pekerjaan berhasil dibuat.');
    }

    /**
     * Display the specified job request.
     */
    public function show(JobRequest $jobRequest)
    {
        $jobRequest->load([
            'user.city',
            'worker.user',
            'skillCategory',
            'city',
            'estimates.worker.user',
            'payments',
            'reviews.reviewer',
            'reviews.reviewee'
        ]);

        // Find nearby workers if job is still open
        $nearbyWorkers = collect();
        if ($jobRequest->status === 'open') {
            $nearbyWorkers = Worker::with(['user', 'skillCategory', 'skillLevel'])
                ->where('skill_category_id', $jobRequest->skill_category_id)
                ->whereHas('user', function ($query) use ($jobRequest) {
                    $query->where('city_id', $jobRequest->city_id);
                })
                ->available()
                ->certified()
                ->orderBy('rating', 'desc')
                ->take(5)
                ->get();
        }

        return Inertia::render('jobs/show', [
            'jobRequest' => $jobRequest,
            'nearbyWorkers' => $nearbyWorkers,
        ]);
    }

    /**
     * Show the form for editing the job request.
     */
    public function edit(JobRequest $jobRequest)
    {
        if (auth()->id() !== $jobRequest->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $skillCategories = SkillCategory::all();
        $cities = City::all();

        return Inertia::render('jobs/edit', [
            'jobRequest' => $jobRequest,
            'skillCategories' => $skillCategories,
            'cities' => $cities,
        ]);
    }

    /**
     * Update the specified job request.
     */
    public function update(UpdateJobRequestRequest $request, JobRequest $jobRequest)
    {
        if (auth()->id() !== $jobRequest->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $jobRequest->update($request->validated());

        return redirect()->route('job-requests.show', $jobRequest)
            ->with('success', 'Permintaan pekerjaan berhasil diperbarui.');
    }

    /**
     * Remove the specified job request.
     */
    public function destroy(JobRequest $jobRequest)
    {
        if (auth()->id() !== $jobRequest->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $jobRequest->delete();

        return redirect()->route('job-requests.index')
            ->with('success', 'Permintaan pekerjaan berhasil dihapus.');
    }


}