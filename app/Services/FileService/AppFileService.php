<?php

namespace App\Services\FileService;

use App\Enums\FileDestination;
use Illuminate\Http\UploadedFile;

interface AppFileService
{
    /**
     * Save Image
     * @param UploadedFile $file
     * @param FileDestination $destination
     * @param string $prefix
     * @return string
     */
    public function saveImage(UploadedFile $file, FileDestination $destination, string $prefix = ""): string|null;

    /**
     * Save Images
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $destination
     * @param string $prefix
     * @return string|null
     */
    public function saveImages(UploadedFile $file, string $destination, string $prefix = ""): string|null;

    /**
     * Remove Public File
     * @param string $fileName
     * @return bool
     */
    public function removePublicFile(string $fileName): bool;

    /**
     * Save Image In Local Storage
     * @param \Illuminate\Http\UploadedFile $file
     * @param \App\Enums\FileDestination $destination
     * @param string $prefix
     * @return string
     */
    public function saveImageInLocalStorage(UploadedFile $file, FileDestination $destination, string $prefix = ""): string;
    /**
     * Save Image In Public Storage
     * @param \Illuminate\Http\UploadedFile $file
     * @param \App\Enums\FileDestination $destination
     * @param string $prefix
     * @param ?string $name
     * @return string
     */
    public function saveImageInPublicStorage(UploadedFile $file, FileDestination $destination, string $prefix = "", string $name = null): string;

    /**
     * Delete File From Storage
     * @param string $file
     * @return bool
     */
    public function removePublicStorageFile(string $file): bool;
}
