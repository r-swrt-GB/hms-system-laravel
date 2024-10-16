<?php

namespace App\Http\Classes\FileUploads;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileUploadService
{
    protected $disk = 's3';

    public function uploadFile($file, string $directory, int $submissionId): File
    {
        try {

            $filename = $file->getClientOriginalName();

            $file->storeAs('avatars/' . $submissionId, $filename, 's3');

            $path = $file->store($directory . '/' . $submissionId, $this->disk);

            $fileModel = new File();
            $fileModel->submission_id = $submissionId;
            $fileModel->filename = $file->getClientOriginalName();
            $fileModel->mimetype = $file->getClientMimeType();
            $fileModel->extension = $file->getClientOriginalExtension();
            $fileModel->size = $file->getSize();
            $fileModel->disk = $this->disk;
            $fileModel->base_url = Storage::disk($this->disk)->url($path);
            $fileModel->key = $path;
            $fileModel->save();

            return $fileModel;
        } catch (\Exception $e) {
            throw new \Exception('File upload failed. Please try again.' . $e->getMessage());
        }
    }

    public function saveFile($file, int $submissionId): File
    {
        try {
            $fileModel = new File();
            $fileModel->submission_id = $submissionId;
            $fileModel->filename = $file['file_name'];
            $fileModel->mimetype = $file['content_type'];
            $fileModel->disk = $this->disk;
            $fileModel->url = $file['file_url'];

            $fileModel->save();

            return $fileModel;
        } catch (\Exception $e) {
            throw new \Exception('File upload failed. Please try again.' . $e->getMessage());
        }
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

        // Check if the file key is empty
        if (empty($file->key)) {
            throw new \Exception('File information is incomplete.');
        }

        // Check if the file exists in storage
        if (!Storage::disk($disk)->exists($file->key)) {
            throw new \Exception('File not found in storage.');
        }

        try {
            return Storage::disk($disk)->download($file->key, $file->filename);
        } catch (\Exception $e) {
            throw new \Exception('Error downloading file. Please try again later.');
        }
    }
}
