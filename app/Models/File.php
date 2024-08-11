<?php

namespace App\Models;

use Carbon\Carbon;
use Cron\AbstractField;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\file
 *
 * @property int $id
 * @property string $filename
 * @property string $mimetype
 * @property string $extension
 * @property int $size
 * @property string $disk
 * @property string $base_url
 * @property string $key
 * @property string $thumbnail_key
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */

/**
 * App\Models\File
 *
 * @property int $id
 * @property int $submission_id
 * @property string $filename
 * @property string $mimetype
 * @property string $extension
 * @property int $size
 * @property string $disk
 * @property string $base_url
 * @property string $key
 * @property string $thumbnail_key
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */

class File extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'filename',
        'mimetype',
        'extension',
        'size',
        'disk',
        'base_url',
        'key',
        'thumbnail_key',
    ];

    protected function casts(): array
    {
        return [
            'submission_id' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    protected $guarded = [];

    public function submissions()
    {
        return $this->belongsToMany(Submission::class);
    }
}
