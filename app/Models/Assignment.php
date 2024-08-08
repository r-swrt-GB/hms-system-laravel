<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    ];

    public function users(): BelongsToMany
    {
       return $this->belongsToMany(User::class, 'user_assignments');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
