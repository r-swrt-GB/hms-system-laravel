<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $role_name
 * @property string $slug
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_name',
        'slug',
        'description'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role');
    }

    public function rights()
    {
        return $this->belongsToMany(Right::class,'role_on_right');
    }

}
