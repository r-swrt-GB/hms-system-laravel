<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


/**
 * App\Models\Right
 *
 * @property int $id
 * @property string $right_name
 * @property string $slug
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Right extends Model
{
    protected $fillable = [
        'right_name',
        'slug',
        'description'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_on_right');
    }
}
