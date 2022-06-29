<?php

namespace App\Services;

use App\Exceptions\FileRelationException;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileService
{
    /**
     * @todo remake it on config
     */
    private const DISC = 'public';

    /**
     * @return File
     */
    public function createFile(): File
    {
        return new File();
    }

    /**
     * @return array
     */
    public function getAllFiles(): array
    {
        $items = File::all();
        $processedItems = [];

        foreach ($items as $item) {
            $processedItems[] = $item;
        }

        return $processedItems;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param string|null $info
     * @return File
     * @throws \Exception
     */
    public function save(UploadedFile $uploadedFile, string $info = null): File
    {
        $fileName = microtime(true) . '.' . $uploadedFile->getClientOriginalName();
        $path = Storage::disk(self::DISC)
            ->putFileAs('uploads', $uploadedFile, $fileName, 'public');
        if ($path === false) {
            throw new \Exception('error file saving on fs');
        }
        $file = $this->createFile();
        $file->name = $fileName;
        $file->path = $path;
        $file->info = $info;
        $file->save();

        return $file;
    }

    /**
     * @param File $file
     * @return bool
     * @throws FileRelationException
     * @throws \Throwable
     */
    public function delete(File $file): bool
    {
        try {
            if ($file->delete()) {
                return Storage::disk(self::DISC)->delete($file->path);
            }
        } catch (\Throwable $e) {
            if ($e->getCode() === '23000') {
                throw new FileRelationException($e->getMessage());
            }
            throw $e;
        }

        return false;
    }

    /**
     * @param int $fileId
     * @return string
     */
    public function getPublicUrl(int $fileId): string
    {
        /** @var File $file */
        $file = File::findOrFail($fileId);

        return Storage::url($file->path);
    }
}
