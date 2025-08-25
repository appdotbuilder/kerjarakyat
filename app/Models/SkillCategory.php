<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\SkillCategory
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Worker> $workers
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\JobRequest> $jobRequests
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|SkillCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SkillCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SkillCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|SkillCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkillCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkillCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkillCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkillCategory whereUpdatedAt($value)
 * @method static \Database\Factories\SkillCategoryFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class SkillCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get the workers in this skill category.
     */
    public function workers(): HasMany
    {
        return $this->hasMany(Worker::class);
    }

    /**
     * Get the job requests for this skill category.
     */
    public function jobRequests(): HasMany
    {
        return $this->hasMany(JobRequest::class);
    }
}