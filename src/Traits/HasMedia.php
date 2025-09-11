<?php

namespace Bakkali\Media\Traits;

use Bakkali\Media\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait HasMedia
{
    /**
     * Relation: Model has many media.
     */
    public function media()
    {
        return $this->morphMany(Media::class, 'model')->orderBy('order_column');
    }

    /**
     * Get all media from a given collection.
     */
    public function getMedia(string $collection = 'default')
    {
        return $this->media()->where('collection_name', $collection)->get();
    }

    /**
     * Add a file record to media collection.
     *
     * @param  UploadedFile $file
     * @param  string       $filePath  Relative path (without disk logic)
     * @param  string       $collection
     * @param  string       $disk
     */
    public function addMedia(
        UploadedFile $file,
        string $filePath,
        string $collection = 'default',
        string $disk = 'public'
    ) {
        // Generate unique file name (uuid + extension)
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

        return $this->media()->create([
            'collection_name'       => $collection,
            'name'                  => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'file_name'             => $fileName,
            'file_path'             => trim($filePath, '/') . '/' . $fileName,
            'mime_type'             => $file->getMimeType(),
            'disk'                  => $disk,
            'size'                  => $file->getSize(),
            'custom_properties'     => [],
            'manipulations'         => [],
            'generated_conversions' => [],
            'responsive_images'     => [],
        ]);
    }

    /**
     * Remove media by ID (only removes DB record, not physical file).
     */
    public function removeMedia(int $mediaId)
    {
        $media = $this->media()->findOrFail($mediaId);
        return $media->delete();
    }

    /**
     * Update existing media attributes.
     */
    public function updateMedia(int $mediaId, array $attributes)
    {
        $media = $this->media()->findOrFail($mediaId);
        $media->update($attributes);

        return $media;
    }

    /**
     * Alias for removeMedia (soft delete).
     */
    public function destroyMedia(int $mediaId)
    {
        return $this->removeMedia($mediaId);
    }

    /**
     * Permanently delete media (ignores soft deletes).
     */
    public function forceDeleteMedia(int $mediaId)
    {
        $media = $this->media()->withTrashed()->findOrFail($mediaId);
        return $media->forceDelete();
    }
}
