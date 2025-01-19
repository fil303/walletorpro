<?php

namespace App\Services\FileService;

use App\Enums\FileDestination;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Services\FileService\Filesystem;
use App\Services\FileService\AppFileService;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileService implements AppFileService
{
    public function __construct(){}

    /**
     * Save File In Public
     * @param UploadedFile $file
     * @param FileDestination $destination
     * @param string $prefix
     * @param string $name
     * @return string
     */
    public function saveImage(UploadedFile $file, FileDestination $destination, string $prefix = "", string $name = ""): ?string
    {
        // $originalName      = $this->getOriginalName($file);
        $originalExtension = $this->getOriginalExtension($file);
        $uniqueCode        = uniqueCode();
        $imageName         = blank($name) ? "$prefix$uniqueCode.$originalExtension" : strtolower($name).".$originalExtension";
        $destinationPath   = public_path($destination->value);

        try{
            $file->move($destinationPath, $imageName);
            return "$destination->value$imageName";
        } catch (FileException $e) {
            logStore("FileService saveImage", $e->getMessage());
            return "";
        }
    }

    /**
     * Save Files In Public
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $destination
     * @param string $prefix
     * @return string|null
     */
    public function saveImages(UploadedFile $file, string $destination, string $prefix = ""): string|null
    {
        return "";
    }

    /**
     * Save File In Local Storage
     * @param \Illuminate\Http\UploadedFile $file
     * @param \App\Enums\FileDestination $destination
     * @param string $prefix
     * @return string
     */
    public function saveImageInLocalStorage(UploadedFile $file, FileDestination $destination, string $prefix = ""): string
    {
        try{
            /** @var string $image */
            $image = Storage::disk('local')->put(
                path    : $destination->storagePath(),
                contents: $file
            );
            return $image;
        } catch (FileException $e) {
            logStore("FileService saveImageInLocalStorage", $e->getMessage());
            return "";
        }
    }

    /**
     * Save File In Public Storage
     * @param \Illuminate\Http\UploadedFile $file
     * @param \App\Enums\FileDestination $destination
     * @param string $prefix
     * @param ?string $name
     * @return string
     */
    public function saveImageInPublicStorage(UploadedFile $file, FileDestination $destination, string $prefix = "", string $name = null): string
    {
        try{
            /** @var Filesystem $fileSystem */
            $fileSystem = Storage::disk('public');
            $name = $name ? strtolower($name).".".$file->extension() : $file->hashName();

            /** @var string $image */
            $image = $fileSystem->putFileAs(
                path: $destination->storagePath(),
                file: $file,
                name: $name
            );
            return $image;
        } catch (FileException $e) {
            logStore("FileService saveImageInLocalStorage", $e->getMessage());
            return "";
        }
    }

    /**
     * Remove File From Public
     * @param string $fileName
     * @return bool
     */
    public function removePublicFile(string $fileName): bool
    {
        if (!filled($fileName)) return false;

        $file = public_path($fileName);
        return file_exists($file) && unlink($file);
    }

    /**
     * Delete File From Storage
     * @param string $file
     * @return bool
     */
    public function removePublicStorageFile(string $file): bool
    {
        if (!filled($file)) return false;
        return Storage::disk("public")->delete($file);
    }

    /**
     * Get File Name
     * @param \Illuminate\Http\UploadedFile $file
     * @return mixed
     */
    public function getOriginalName(UploadedFile $file): mixed
    {
        return $file->getClientOriginalName();
    }

    /**
     * Get File Extension
     * @param \Illuminate\Http\UploadedFile $file
     * @return mixed
     */
    public function getOriginalExtension(UploadedFile $file): mixed
    {
        return $file->getClientOriginalExtension();
    }
}
