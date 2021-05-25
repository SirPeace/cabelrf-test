<?php

namespace App;

use App\Exceptions\UnsupportedFileTypeException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

abstract class UploadManager
{
    const PATH = "";
    const SUPPORTED_MIME_TYPES = [];
    const DEFAULT_FILE = "";

    /**
     * Store file and return its path
     *
     * @return string
     */
    public function store(UploadedFile $file): string
    {
        $this->checkMimeType($file);

        return $file->store(static::PATH);
    }

    /**
     * Delete old file, store a new one,
     * and return its path
     *
     * @param string $oldThumbnailPath
     * @return string
     */
    public function update(UploadedFile $file, string $oldFile): string
    {
        $this->checkMimeType($file);
        $this->delete($oldFile);

        return $file->store(static::PATH);
    }

    /**
     * Throw *UnsupportedFileExtenstion* exception
     * if file has unsupported MIME type
     *
     * @return void
     */
    public function checkMimeType(UploadedFile $file): void
    {
        if (!in_array($file->getMimeType(), static::SUPPORTED_MIME_TYPES)) {
            throw new UnsupportedFileTypeException(
                'Unsupported file extenstion. Can upload only .jpeg/.jpg and .png'
            );
        }
    }

    /**
     * Delete file if it is not default
     *
     * @return void
     */
    public function delete(string $path): void
    {
        if (
            Storage::exists($path) &&
            $path !== static::PATH . static::DEFAULT_FILE
        ) {
            Storage::delete($path);
        }
    }
}
