<?php

namespace App\Http\Classes\FileUploads;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    /**
     * Upload a file and save its information in the database.
     *
     * @param string $directory
     * @param int $submissionId
     * @return File
     */
    public function uploadFile($file, string $directory, int $submissionId): File
    {
        $disk = 's3';
        $path = $file->store($directory . '/' . $submissionId, $disk);

        $fileModel = new File();
        $fileModel->submission_id = $submissionId;
        $fileModel->filename = $file->getClientOriginalName();
        $fileModel->mimetype = $file->getClientMimeType();
        $fileModel->extension = $file->getClientOriginalExtension();
        $fileModel->size = $file->getSize();
        $fileModel->disk = $disk;
        $fileModel->base_url = Storage::disk($disk)->url($path);
        $fileModel->key = $path;

        //TODO: add thumbnail key
        $fileModel->thumbnail_key = null;

        $fileModel->save();

        return $fileModel;
    }
}
