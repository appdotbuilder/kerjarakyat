<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JobEstimate;
use Illuminate\Http\Request;

class EstimateActionController extends Controller
{
    /**
     * Approve the job estimate (client approves the estimate).
     */
    public function store(Request $request)
    {
        $estimateId = $request->get('estimate_id');
        $action = $request->get('action');
        
        $jobEstimate = JobEstimate::findOrFail($estimateId);
        $jobRequest = $jobEstimate->jobRequest;
        
        if (auth()->id() !== $jobRequest->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        if ($action === 'approve') {
            $jobEstimate->update(['status' => 'approved']);
            $jobRequest->update([
                'status' => 'approved',
                'estimated_cost' => $jobEstimate->total_cost,
            ]);

            return back()->with('success', 'Estimasi pekerjaan disetujui. Kontrak kerja akan segera dibuat.');
        } elseif ($action === 'reject') {
            $jobEstimate->update([
                'status' => 'rejected',
                'notes' => $request->get('rejection_reason'),
            ]);
            
            $jobRequest->update(['status' => 'survey_scheduled']); // Back to survey phase

            return back()->with('success', 'Estimasi pekerjaan ditolak. Silakan diskusikan dengan tukang untuk revisi.');
        }

        return back()->with('error', 'Aksi tidak valid.');
    }
}