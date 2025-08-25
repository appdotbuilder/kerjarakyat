<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JobRequest;
use Illuminate\Http\Request;

class JobActionController extends Controller
{
    /**
     * Handle job actions (apply, accept survey, etc.).
     */
    public function store(Request $request)
    {
        $jobId = $request->get('job_id');
        $action = $request->get('action');
        
        $jobRequest = JobRequest::findOrFail($jobId);

        if ($action === 'apply') {
            $worker = auth()->user()->worker;
            
            if (!$worker) {
                return back()->with('error', 'Anda harus memiliki profil tukang untuk melamar pekerjaan.');
            }

            if ($jobRequest->status !== 'open') {
                return back()->with('error', 'Pekerjaan ini sudah tidak tersedia.');
            }

            // Create survey request
            $jobRequest->update([
                'status' => 'survey_requested',
                'worker_id' => $worker->id,
            ]);

            return back()->with('success', 'Permintaan survey berhasil dikirim kepada klien.');
        } elseif ($action === 'accept_survey') {
            if (auth()->id() !== $jobRequest->user_id && !auth()->user()->isAdmin()) {
                abort(403, 'Unauthorized');
            }

            $jobRequest->update([
                'status' => 'survey_scheduled'
            ]);

            return back()->with('success', 'Permintaan survey diterima. Silakan koordinasi dengan tukang untuk jadwal survey.');
        }

        return back()->with('error', 'Aksi tidak valid.');
    }
}