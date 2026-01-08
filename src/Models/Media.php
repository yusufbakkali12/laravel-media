<?php

namespace Bakkali\Media\Models;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use SoftDeletes;

    protected $table = 'media';

    protected $fillable = [
        'model_type',
        'model_id',
        'uuid',
        'collection_name',
        'name',
        'file_name',
        'file_path',
        'mime_type',
        'disk',
        'conversions_disk',
        'size',
        'manipulations',
        'custom_properties',
        'generated_conversions',
        'responsive_images',
        'order_column',
    ];


    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'media_tag');
    }

    protected $casts = [
        'manipulations' => 'array',
        'custom_properties' => 'array',
        'generated_conversions' => 'array',
        'responsive_images' => 'array',
    ];


    // helper to get tag names
    public function getTagListAttribute()
    {
        return $this->tags()->pluck('name')->toArray();
    }


    public function getSizeAttribute($value): string
    {
        if (!$value) {
            return '';
        }

        if ($value < 1024) {
            return $value . ' B';
        }

        if ($value < 1024 * 1024) {
            return round($value / 1024, 2) . ' KB';
        }

        return round($value / (1024 * 1024), 2) . ' MB';
    }


    public function model()
    {
        return $this->morphTo();
    }
}
