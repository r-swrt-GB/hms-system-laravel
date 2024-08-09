<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Submission
 *
 * @property int $id
 * @property int $assignment_id
 * @property Carbon $submission_date
 * @property int $grade
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */

class Submission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'submission_date',
        'grade',
    ];

    /**
     * Get the attributes that should be cast
     */
    protected function casts(): array
    {
        return [
            'assignment_id' => 'integer',
            'submission_date' => 'datetime',
            'grade' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns the submission
     */
    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_submissions');
    }
}
