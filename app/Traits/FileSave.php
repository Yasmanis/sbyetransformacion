<?php

namespace App\Traits;

trait FileSave
{
    public function getPropertiesFromFile($file, $directory, $disk = 'public')
    {
        $originalName = $file->getClientOriginalName();
        $path = $file->store($directory, $disk);
        return array(
            'originalName' => $originalName,
            'path' => $path,
            'type' => mime_content_type(storage_path(sprintf('app/%s/%s', $disk, $path))),
            'size' => filesize(storage_path(sprintf('app/%s/%s', $disk, $path)))
        );
    }

    public function formatSize($bytes)
    {
        if ($bytes == 0) return '0 B';
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $index = floor(log($bytes, 1024));
        return round($bytes / pow(1024, $index), 2) . ' ' . $units[$index];
    }
}
