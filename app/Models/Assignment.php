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
        'min_videos',
        'max_videos',
        'max_video_length',
        'max_grade',
        'open_date',
        'due_date',
        'created_at',
        'updated_at',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_assignments');
    }

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
}