<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property string api_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'api_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    public function hasRole(string $roleSlug): bool
    {
        return $this->roles()->where('slug', $roleSlug)->exists();
    }

    public function submissions(): BelongsToMany
    {
        return $this->belongsToMany(Submission::class, 'user_submissions');
    }

    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(Module::class, 'user_modules');
    }

    public function comments(): hasMany
    {
        return $this->hasMany(Comment::class);
    }

    // Relationship with Notification
    public function notifications()
    {
        return $this->belongsToMany(Notification::class,'user_on_notification');
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'user_groups');
    }

    public function assignments(): BelongsToMany
    {
        return $this->belongsToMany(Assignment::class, 'user_assignments');
    }
}
