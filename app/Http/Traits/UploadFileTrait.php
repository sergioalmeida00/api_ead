<?php

namespace App\Http\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadFileTrait
{
    protected function uploadStore(UploadedFile $file, $path)
    {
        return $file->store($path);
    }

    protected function uploadStoreAs(UploadedFile $file, $path, $customName)
    {
        return $file->storeAs($path, $customName);
    }

    protected function uploadRemove($filePath)
    {
        if (!Storage::exists($filePath)) {
            return false;
        }

        return Storage::delete($filePath);
    }
}
