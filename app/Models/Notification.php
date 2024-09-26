<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * APP\Models\Notification
 *
 * @property int $id
 * @property int $user_id
 * @property int $module_id
 * @property string $title
 * @property string $message
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */

class Notification extends Model
{
    use HasFactory;

    /**
     * Attributes that are mass assignable
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'module_id',
        'title',
        'message',
    ];


    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Module
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function assignments(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }
}
