<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Worker
 *
 * @property int $id
 * @property int $user_id
 * @property int $skill_category_id
 * @property int $skill_level_id
 * @property string|null $certification_number
 * @property \Illuminate\Support\Carbon|null $certification_date
 * @property \Illuminate\Support\Carbon|null $certification_expiry
 * @property string $certification_status
 * @property string|null $bio
 * @property float $rating
 * @property int $total_jobs
 * @property int $total_reviews
 * @property bool $is_available
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\SkillCategory $skillCategory
 * @property-read \App\Models\SkillLevel $skillLevel
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\JobRequest> $jobRequests
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\JobEstimate> $jobEstimates
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $receivedPayments
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Worker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Worker newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Worker query()
 * @method static \Illuminate\Database\Eloquent\Builder|Worker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Worker whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Worker whereSkillCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Worker whereSkillLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Worker whereCertificationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Worker whereCertificationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Worker whereCertificationExpiry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Worker whereCertificationStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Worker whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Worker whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Worker whereTotalJobs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Worker whereTotalReviews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Worker whereIsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Worker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Worker whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Worker available()
 * @method static \Illuminate\Database\Eloquent\Builder|Worker certified()
 * @method static \Database\Factories\WorkerFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Worker extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'skill_category_id',
        'skill_level_id',
        'certification_number',
        'certification_date',
        'certification_expiry',
        'certification_status',
        'bio',
        'rating',
        'total_jobs',
        'total_reviews',
        'is_available',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'certification_date' => 'date',
        'certification_expiry' => 'date',
        'rating' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    /**
     * Get the user that owns the worker profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the skill category for this worker.
     */
    public function skillCategory(): BelongsTo
    {
        return $this->belongsTo(SkillCategory::class);
    }

    /**
     * Get the skill level for this worker.
     */
    public function skillLevel(): BelongsTo
    {
        return $this->belongsTo(SkillLevel::class);
    }

    /**
     * Get the job requests assigned to this worker.
     */
    public function jobRequests(): HasMany
    {
        return $this->hasMany(JobRequest::class);
    }

    /**
     * Get the job estimates created by this worker.
     */
    public function jobEstimates(): HasMany
    {
        return $this->hasMany(JobEstimate::class);
    }

    /**
     * Get the payments received by this worker.
     */
    public function receivedPayments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Scope a query to only include available workers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope a query to only include certified workers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCertified($query)
    {
        return $query->where('certification_status', 'certified');
    }
}