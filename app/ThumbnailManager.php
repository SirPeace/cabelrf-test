<?php

namespace App;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\UnsupportedThumbnailType;

class ThumbnailManager
{
    const PATH = "public/product-images";
    const SUPPORTED_MIME_TYPES = ['image/png', 'image/jpeg'];

    /**
     * Store thumbnail and return its path
     *
     * @return string
     */
    public function store(UploadedFile $file): string
    {
        $this->checkMimeType($file);

        return $file->store(self::PATH);
    }

    /**
     * Delete old thumbnail, store a new one,
     * and return its path
     *
     * @param string $oldThumbnailPath
     * @return string
     */
    public function update(UploadedFile $file, string $oldThumbnailPath): string
    {
        $this->checkMimeType($file);
        $this->deleteThumbnail($oldThumbnailPath);

        return $file->store(self::PATH);
    }

    /**
     * Throw *UnsupportedThumbnailExtenstion* exception
     * if file has unsupported MIME type
     *
     * @return void
     */
    public function checkMimeType(UploadedFile $file): void
    {
        if (!in_array($file->getMimeType(), self::SUPPORTED_MIME_TYPES)) {
            throw new UnsupportedThumbnailType(
                'Unsupported file extenstion. Can upload only .jpeg/.jpg and .png'
            );
        }
    }

    /**
     * Delete thumbnail if it is not default
     *
     * @return void
     */
    public function deleteThumbnail(string $path): void
    {
        if (
            Storage::exists($path) &&
            $path !== self::PATH . "/default.png"
        ) {
            Storage::delete($path);
        }
    }
}
