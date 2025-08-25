<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\JobRequest
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $worker_id
 * @property int $skill_category_id
 * @property int $city_id
 * @property string $title
 * @property string $description
 * @property string $location_address
 * @property float|null $location_latitude
 * @property float|null $location_longitude
 * @property \Illuminate\Support\Carbon $preferred_start_date
 * @property int $estimated_duration_days
 * @property int|null $estimated_duration_hours
 * @property string $urgency
 * @property string $status
 * @property float|null $estimated_cost
 * @property float|null $final_cost
 * @property \Illuminate\Support\Carbon|null $actual_start_date
 * @property \Illuminate\Support\Carbon|null $actual_end_date
 * @property string|null $client_notes
 * @property string|null $worker_notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Worker|null $worker
 * @property-read \App\Models\SkillCategory $skillCategory
 * @property-read \App\Models\City $city
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\JobEstimate> $estimates
 * @property-read \App\Models\JobEstimate|null $approvedEstimate
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest whereWorkerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest whereSkillCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest whereLocationAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest whereLocationLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest whereLocationLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest wherePreferredStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest whereEstimatedDurationDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest whereEstimatedDurationHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest whereUrgency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest whereEstimatedCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest whereFinalCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest whereActualStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest whereActualEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest whereClientNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest whereWorkerNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest open()
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest inProgress()
 * @method static \Illuminate\Database\Eloquent\Builder|JobRequest completed()

 * 
 * @mixin \Eloquent
 */
class JobRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'worker_id',
        'skill_category_id',
        'city_id',
        'title',
        'description',
        'location_address',
        'location_latitude',
        'location_longitude',
        'preferred_start_date',
        'estimated_duration_days',
        'estimated_duration_hours',
        'urgency',
        'status',
        'estimated_cost',
        'final_cost',
        'actual_start_date',
        'actual_end_date',
        'client_notes',
        'worker_notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'location_latitude' => 'decimal:8',
        'location_longitude' => 'decimal:8',
        'preferred_start_date' => 'datetime',
        'actual_start_date' => 'datetime',
        'actual_end_date' => 'datetime',
        'estimated_cost' => 'decimal:2',
        'final_cost' => 'decimal:2',
    ];

    /**
     * Get the client who created the job request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the assigned worker.
     */
    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }

    /**
     * Get the skill category for this job.
     */
    public function skillCategory(): BelongsTo
    {
        return $this->belongsTo(SkillCategory::class);
    }

    /**
     * Get the city where this job is located.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the estimates for this job.
     */
    public function estimates(): HasMany
    {
        return $this->hasMany(JobEstimate::class);
    }

    /**
     * Get the approved estimate for this job.
     */
    public function approvedEstimate(): HasOne
    {
        return $this->hasOne(JobEstimate::class)->where('status', 'approved');
    }

    /**
     * Get the payments for this job.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the reviews for this job.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Scope a query to only include open job requests.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    /**
     * Scope a query to only include jobs in progress.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope a query to only include completed jobs.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}