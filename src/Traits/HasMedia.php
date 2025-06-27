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
            'collection_name' => $collection,
            'name' => pathinfo($fileName, PATHINFO_FILENAME),
            'file_name' => $fileName,
            'mime_type' => $mimeType,
            'disk' => $disk,
            'size' => $size,
        ]);
    }

    public function removeMedia(int $mediaId)
    {
        $media = $this->media()->findOrFail($mediaId);
        $media->delete();
    }
}
