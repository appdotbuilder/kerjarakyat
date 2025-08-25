<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\JobEstimate
 *
 * @property int $id
 * @property int $job_request_id
 * @property int $worker_id
 * @property int $estimated_days
 * @property int|null $estimated_hours
 * @property float $labor_cost
 * @property float $bpjs_health
 * @property float $bpjs_employment
 * @property float $app_commission
 * @property float $total_cost
 * @property \Illuminate\Support\Carbon $estimated_start_date
 * @property \Illuminate\Support\Carbon $estimated_completion_date
 * @property string|null $notes
 * @property string $status
 * @property \Illuminate\Support\Carbon $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\JobRequest $jobRequest
 * @property-read \App\Models\Worker $worker
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|JobEstimate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobEstimate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobEstimate query()
 * @method static \Illuminate\Database\Eloquent\Builder|JobEstimate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobEstimate whereJobRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobEstimate whereWorkerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobEstimate whereEstimatedDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobEstimate whereEstimatedHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobEstimate whereLaborCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobEstimate whereBpjsHealth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobEstimate whereBpjsEmployment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobEstimate whereAppCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobEstimate whereTotalCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobEstimate whereEstimatedStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobEstimate whereEstimatedCompletionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobEstimate whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobEstimate whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobEstimate whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobEstimate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobEstimate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobEstimate pending()
 * @method static \Illuminate\Database\Eloquent\Builder|JobEstimate approved()

 * 
 * @mixin \Eloquent
 */
class JobEstimate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'job_request_id',
        'worker_id',
        'estimated_days',
        'estimated_hours',
        'labor_cost',
        'bpjs_health',
        'bpjs_employment',
        'app_commission',
        'total_cost',
        'estimated_start_date',
        'estimated_completion_date',
        'notes',
        'status',
        'expires_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'labor_cost' => 'decimal:2',
        'bpjs_health' => 'decimal:2',
        'bpjs_employment' => 'decimal:2',
        'app_commission' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'estimated_start_date' => 'datetime',
        'estimated_completion_date' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the job request that this estimate belongs to.
     */
    public function jobRequest(): BelongsTo
    {
        return $this->belongsTo(JobRequest::class);
    }

    /**
     * Get the worker who created this estimate.
     */
    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }

    /**
     * Scope a query to only include pending estimates.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include approved estimates.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}