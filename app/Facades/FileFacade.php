<?php

namespace App\Facades;

use App\Enums\FileDestination;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Facade;
use App\Services\FileService\AppFileService;

/**
 * This Facade is to upload file on server;
 * 
 * @method static string saveImage(UploadedFile|array<UploadedFile>|null $file, FileDestination $destination, string $prefix = "", string $name = "")
 * @method static bool removePublicFile(string $fileName)
 * @method static string saveImageInPublicStorage(UploadedFile $file, FileDestination $destination, string $prefix = "", string $name = null)
 * @method static string saveImageInLocalStorage(UploadedFile $file, FileDestination $destination, string $prefix = "")
 * @method static bool removePublicStorageFile(string $file)
 * 
 * @see App\Services\FileService\FileService
 */
class FileFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return AppFileService::class;
    }

}
