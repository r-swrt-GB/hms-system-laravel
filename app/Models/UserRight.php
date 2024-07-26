<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\User\UserRight
 *
 * @method static Builder|UserRight newModelQuery()
 * @method static Builder|UserRight newQuery()
 * @method static Builder|UserRight query()
 * @mixin Eloquent
 */
class UserRight extends Model
{
    use HasFactory;

    public $guarded = [];
}
