<?php

namespace App\Http\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HandlesImageUploads
{
    /**
     * Uploads an image to the specified disk and folder.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @param string $disk
     * @return string|false
     */
    protected function uploadImage(UploadedFile $file, string $folder, string $disk = 'public')
    {
        return $file->store($folder, $disk);
    }

    /**
     * Deletes an image from the specified disk.
     *
     * @param string|null $path
     * @param string $disk
     * @return void
     */
    protected function deleteImage(?string $path, string $disk = 'public'): void
    {
        if ($path) {
            Storage::disk($disk)->delete($path);
        }
    }
} 