<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\SkillLevel
 *
 * @property int $id
 * @property string $name
 * @property float $hourly_rate_multiplier
 * @property float $daily_rate_multiplier
 * @property float $overtime_rate_multiplier
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Worker> $workers
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|SkillLevel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SkillLevel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SkillLevel query()
 * @method static \Illuminate\Database\Eloquent\Builder|SkillLevel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkillLevel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkillLevel whereHourlyRateMultiplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkillLevel whereDailyRateMultiplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkillLevel whereOvertimeRateMultiplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkillLevel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkillLevel whereUpdatedAt($value)
 * @method static \Database\Factories\SkillLevelFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class SkillLevel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'hourly_rate_multiplier',
        'daily_rate_multiplier',
        'overtime_rate_multiplier',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'hourly_rate_multiplier' => 'decimal:2',
        'daily_rate_multiplier' => 'decimal:2',
        'overtime_rate_multiplier' => 'decimal:2',
    ];

    /**
     * Get the workers with this skill level.
     */
    public function workers(): HasMany
    {
        return $this->hasMany(Worker::class);
    }
}