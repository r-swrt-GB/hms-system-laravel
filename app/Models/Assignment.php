<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\Assignment
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $min_videos
 * @property int $max_videos
 * @property int $max_video_length
 * @property int $max_grade
 * @property Carbon|null $open_date
 * @property Carbon|null $due_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Assignment extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'title',
        'description',
        'type',
        'min_videos',
        'max_videos',
        'max_video_length',
        'max_grade',
        'open_date',
        'due_date',
        'module_id',
        'user_id',
        'created_at',
        'updated_at',
    ];

    const TYPE_INDIVIDUAL = 'individual';
    const TYPE_GROUP = 'group';

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function created_by(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function isIndividual(): bool
    {
        return $this->type === self::TYPE_INDIVIDUAL;
    }

    public function isGroup(): bool
    {
        return $this->type === self::TYPE_GROUP;
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_assignments');
    }
}
