<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobEstimateRequest;
use App\Http\Requests\UpdateJobEstimateRequest;
use App\Models\JobEstimate;
use App\Models\JobRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JobEstimateController extends Controller
{
    /**
     * Display a listing of job estimates.
     */
    public function index(Request $request)
    {
        $query = JobEstimate::with(['jobRequest.user', 'worker.user']);

        // Filter by worker for worker dashboard
        if (auth()->user()->isWorker()) {
            $query->where('worker_id', auth()->user()->worker->id);
        }

        $estimates = $query->latest()->paginate(10);

        return Inertia::render('estimates/index', [
            'estimates' => $estimates,
        ]);
    }

    /**
     * Show the form for creating a new job estimate.
     */
    public function create(Request $request)
    {
        $jobRequestId = $request->get('job_request_id');
        $jobRequest = JobRequest::with(['user', 'skillCategory', 'city'])->findOrFail($jobRequestId);

        // Only the assigned worker can create estimate
        if (!auth()->user()->isWorker() || auth()->user()->worker->id !== $jobRequest->worker_id) {
            abort(403, 'Unauthorized');
        }

        return Inertia::render('estimates/create', [
            'jobRequest' => $jobRequest,
        ]);
    }

    /**
     * Store a newly created job estimate.
     */
    public function store(StoreJobEstimateRequest $request)
    {
        $data = $request->validated();
        $data['worker_id'] = auth()->user()->worker->id;
        
        // Calculate costs based on worker's skill level and city minimum wage
        $jobRequest = JobRequest::with(['city', 'worker.skillLevel'])->findOrFail($data['job_request_id']);
        $skillLevel = $jobRequest->worker->skillLevel;
        $minimumWage = $jobRequest->city->minimum_wage;
        
        // Calculate daily rate
        $dailyRate = $minimumWage * $skillLevel->daily_rate_multiplier;
        $laborCost = $dailyRate * $data['estimated_days'];
        
        // Add hourly cost if specified
        if (isset($data['estimated_hours'])) {
            $hourlyRate = $dailyRate / 8; // 8 hours per day
            $laborCost += $hourlyRate * $data['estimated_hours'];
        }
        
        // Calculate BPJS contributions (estimated percentages)
        $bpjsHealth = $laborCost * 0.01; // 1% for health
        $bpjsEmployment = $laborCost * 0.037; // 3.7% for employment
        $appCommission = $laborCost * 0.05; // 5% app commission
        
        $data['labor_cost'] = $laborCost;
        $data['bpjs_health'] = $bpjsHealth;
        $data['bpjs_employment'] = $bpjsEmployment;
        $data['app_commission'] = $appCommission;
        $data['total_cost'] = $laborCost + $bpjsHealth + $bpjsEmployment + $appCommission;
        $data['expires_at'] = now()->addDays(7); // Estimate expires in 7 days

        $estimate = JobEstimate::create($data);
        
        // Update job request status
        $jobRequest->update(['status' => 'estimated']);

        return redirect()->route('job-requests.show', $jobRequest)
            ->with('success', 'Estimasi pekerjaan berhasil dibuat.');
    }

    /**
     * Display the specified job estimate.
     */
    public function show(JobEstimate $jobEstimate)
    {
        $jobEstimate->load(['jobRequest.user', 'worker.user']);

        return Inertia::render('estimates/show', [
            'estimate' => $jobEstimate,
        ]);
    }

    /**
     * Show the form for editing the job estimate.
     */
    public function edit(JobEstimate $jobEstimate)
    {
        if (!auth()->user()->isWorker() || auth()->user()->worker->id !== $jobEstimate->worker_id) {
            abort(403, 'Unauthorized');
        }

        return Inertia::render('estimates/edit', [
            'estimate' => $jobEstimate,
        ]);
    }

    /**
     * Update the specified job estimate.
     */
    public function update(UpdateJobEstimateRequest $request, JobEstimate $jobEstimate)
    {
        if (!auth()->user()->isWorker() || auth()->user()->worker->id !== $jobEstimate->worker_id) {
            abort(403, 'Unauthorized');
        }

        $jobEstimate->update($request->validated());

        return redirect()->route('job-estimates.show', $jobEstimate)
            ->with('success', 'Estimasi pekerjaan berhasil diperbarui.');
    }

    /**
     * Remove the specified job estimate.
     */
    public function destroy(JobEstimate $jobEstimate)
    {
        if (!auth()->user()->isWorker() || auth()->user()->worker->id !== $jobEstimate->worker_id) {
            abort(403, 'Unauthorized');
        }

        $jobEstimate->delete();

        return redirect()->route('job-estimates.index')
            ->with('success', 'Estimasi pekerjaan berhasil dihapus.');
    }


}