<?php

namespace Bakkali\Media\Traits;

use Bakkali\Media\Models\Media;

trait HasMedia
{
    public function media()
    {
        return $this->morphMany(Media::class, 'model')->orderBy('order_column');
    }

    public function getMedia(string $collection)
    {
        return $this->media()->where('collection_name', $collection)->get();
    }

    public function addMedia(string $filePath, string $collection = 'default', string $disk = 'public')
    {
        $fileName = basename($filePath);
        $mimeType = mime_content_type($filePath);
        $size = filesize($filePath);

        return $this->media()->create([
            'collection_name'     => $collection,
            'name'                => pathinfo($fileName, PATHINFO_FILENAME),
            'file_name'           => $fileName,
            'mime_type'           => $mimeType,
            'disk'                => $disk,
            'size'                => $size,
            'custom_properties'   => [],
            'manipulations'       => [],
            'generated_conversions' => [],
            'responsive_images'   => [],
        ]);
    }

    public function removeMedia(int $mediaId)
    {
        $media = $this->media()->findOrFail($mediaId);
        return $media->delete();
    }

    /**
     * Update properties of existing media.
     * Example: $post->updateMedia($mediaId, ['name' => 'New name']);
     */
    public function updateMedia(int $mediaId, array $attributes)
    {
        $media = $this->media()->findOrFail($mediaId);
        $media->update($attributes);
        return $media;
    }

    /**
     * Soft delete media (equivalent to removeMedia).
     */
    public function destroyMedia(int $mediaId)
    {
        return $this->removeMedia($mediaId);
    }

    /**
     * Force delete media permanently (ignores soft deletes).
     */
    public function forceDeleteMedia(int $mediaId)
    {
        $media = $this->media()->withTrashed()->findOrFail($mediaId);
        return $media->forceDelete();
    }
}
