<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Assignment
 *
 * @property int $id
 * @property string $title
 * @property int $assignment_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'assignment_id',
        'created_at',
        'updated_at',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_groups');
    }

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }
}
