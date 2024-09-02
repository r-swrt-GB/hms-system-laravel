<?php

namespace App\Http\Classes\FileUploads;

use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileUploadService
{
    /**
     * Upload a file and save its information in the database.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param int $submissionId
     * @return File
     */
    public function uploadFile($file, string $directory, int $submissionId): File
    {
        $disk = 'azure';
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

    /**
     * Download a file from storage.
     *
     * @param File $file
     * @return StreamedResponse
     */
    public function downloadFile(File $file): StreamedResponse
    {
        $disk = $file->disk;

        // Check if the file exists in storage
        if (!Storage::disk($disk)->exists($file->key)) {
            abort(404, 'File not found.');
        }

        return Storage::disk($disk)->download($file->key, $file->filename);
    }
}
