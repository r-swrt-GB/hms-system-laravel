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
 * @property string $type
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
        'usr_id',
        'module_id',
        'tile',
        'type',
        'message',
    ];

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'user_on_notification');
    }

    public function assignments(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }
}
