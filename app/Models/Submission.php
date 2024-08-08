<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\Submission
 *
 * @property int $id
 * @property Carbon|null $submission_date
 * @property int $grade
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */

class Submission extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable
     *
     * @var array<int, string>
     */

    public function assignments()
    {
        return $this->belongsToMany(Assignment::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
