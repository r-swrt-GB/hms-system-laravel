<?php

namespace App\Models;

use App\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;


/**
 * App\Models\User\Right
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $scope
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|User[] $users
 * @property-read int|null $users_count
 * @method static Builder|Right newModelQuery()
 * @method static Builder|Right newQuery()
 * @method static Builder|Right query()
 * @method static Builder|Right whereCreatedAt($value)
 * @method static Builder|Right whereId($value)
 * @method static Builder|Right whereName($value)
 * @method static Builder|Right whereScope($value)
 * @method static Builder|Right whereSlug($value)
 * @method static Builder|Right whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Right extends Model
{
    public $timestamps = true;
    public $guarded = [];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_right');
    }
}
