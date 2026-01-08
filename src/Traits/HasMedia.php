<?php

namespace Bakkali\Media\Traits;


use Bakkali\Media\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
    public function getMedia(?string $collection = null, bool $latest = false)
    {
        $query = $this->media();
        if ($collection) {
            $query->where('collection_name', $collection);
        }

        $query->with('tags');
        $query->orderBy('id');
        return $latest ? $query->latest()->first() : $query->get();
    }


    /**
     * Add a file record to media collection.
     *
     * @param UploadedFile  $file
     * @param  string       $filePath  Relative path (without disk logic)
     * @param  string       $collection
     * @param  string       $disk
     */
    public function addMedia( UploadedFile $file, string $directory, string $collection = 'default', string $disk = 'minio' ): Media|null {

        $uuid = Str::uuid();
        // Generate unique file name
        $fileName = $uuid . '.' . $file->getClientOriginalExtension();
        $filePath = trim($directory, '/') . '/' . $fileName;

        $save = Storage::disk($disk)->put($filePath, file_get_contents($file));
        if (!$save) return null;

        $media = $this->media()->create([
            'uuid'                  => $uuid,
            'collection_name'       => $collection,
            'name'                  => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'file_name'             => $fileName,
            'file_path'             => $filePath,
            'mime_type'             => $file->getMimeType(),
            'disk'                  => $disk,
            'conversions_disk'      => $disk,
            'size'                  => $file->getSize(),
            'order_column'          => $this->media()->max('order_column') + 1 ?? 1,
            'manipulations'         => [],
            'custom_properties'     => [],
            'generated_conversions' => [],
            'responsive_images'     => [],
        ]);

        return $media;
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
