<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JobRequest;
use App\Models\Worker;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $data = [
            'user' => $user,
        ];

        if ($user->isWorker() && $user->worker) {
            // Worker dashboard data
            $worker = $user->worker;
            $data['worker'] = $worker->load(['skillCategory', 'skillLevel']);
            
            // Recent job requests for this worker
            $data['recentJobs'] = JobRequest::where('worker_id', $worker->id)
                ->with(['user', 'skillCategory', 'city'])
                ->latest()
                ->take(5)
                ->get();
                
            // Available jobs in same city and skill category
            $data['availableJobs'] = JobRequest::where('status', 'open')
                ->where('skill_category_id', $worker->skill_category_id)
                ->whereHas('user', function ($query) use ($user) {
                    $query->where('city_id', $user->city_id);
                })
                ->with(['user', 'skillCategory', 'city'])
                ->latest()
                ->take(5)
                ->get();
                
            // Statistics
            $data['stats'] = [
                'completedJobs' => JobRequest::where('worker_id', $worker->id)
                    ->where('status', 'completed')
                    ->count(),
                'activeJobs' => JobRequest::where('worker_id', $worker->id)
                    ->whereIn('status', ['approved', 'in_progress'])
                    ->count(),
                'rating' => $worker->rating,
                'totalReviews' => $worker->total_reviews,
            ];
            
        } else {
            // Client dashboard data
            $data['myJobs'] = JobRequest::where('user_id', $user->id)
                ->with(['worker.user', 'skillCategory', 'city'])
                ->latest()
                ->take(5)
                ->get();
                
            // Nearby workers
            if ($user->city_id) {
                $data['nearbyWorkers'] = Worker::whereHas('user', function ($query) use ($user) {
                    $query->where('city_id', $user->city_id);
                })
                ->with(['user', 'skillCategory', 'skillLevel'])
                ->available()
                ->certified()
                ->orderBy('rating', 'desc')
                ->take(6)
                ->get();
            } else {
                $data['nearbyWorkers'] = collect();
            }
            
            // Statistics
            $data['stats'] = [
                'totalJobs' => JobRequest::where('user_id', $user->id)->count(),
                'completedJobs' => JobRequest::where('user_id', $user->id)
                    ->where('status', 'completed')
                    ->count(),
                'activeJobs' => JobRequest::where('user_id', $user->id)
                    ->whereIn('status', ['approved', 'in_progress'])
                    ->count(),
                'pendingJobs' => JobRequest::where('user_id', $user->id)
                    ->whereIn('status', ['open', 'survey_requested', 'estimated'])
                    ->count(),
            ];
        }

        return Inertia::render('dashboard', $data);
    }
}