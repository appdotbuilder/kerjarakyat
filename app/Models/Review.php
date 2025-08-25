<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Review
 *
 * @property int $id
 * @property int $job_request_id
 * @property int $reviewer_id
 * @property int $reviewee_id
 * @property int $rating
 * @property string|null $comment
 * @property string $type
 * @property bool $is_visible
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\JobRequest $jobRequest
 * @property-read \App\Models\User $reviewer
 * @property-read \App\Models\User $reviewee
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review query()
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereJobRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereReviewerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereRevieweeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereIsVisible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Review forWorkers()
 * @method static \Illuminate\Database\Eloquent\Builder|Review forClients()

 * 
 * @mixin \Eloquent
 */
class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'job_request_id',
        'reviewer_id',
        'reviewee_id',
        'rating',
        'comment',
        'type',
        'is_visible',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_visible' => 'boolean',
    ];

    /**
     * Get the job request for this review.
     */
    public function jobRequest(): BelongsTo
    {
        return $this->belongsTo(JobRequest::class);
    }

    /**
     * Get the user who gave the review.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    /**
     * Get the user who received the review.
     */
    public function reviewee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewee_id');
    }

    /**
     * Scope a query to only include visible reviews.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * Scope a query to only include reviews for workers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForWorkers($query)
    {
        return $query->where('type', 'client_to_worker');
    }

    /**
     * Scope a query to only include reviews for clients.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForClients($query)
    {
        return $query->where('type', 'worker_to_client');
    }
}