<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageStorage
{
    public static function store(UploadedFile $file, string $directory): string
    {
        if (! $file->isValid()) {
            throw new \RuntimeException($file->getErrorMessage() ?: 'The uploaded file is invalid.');
        }

        $targetDir = public_path('uploads/' . trim($directory, '/'));

        if (! is_dir($targetDir) && ! @mkdir($targetDir, 0755, true) && ! is_dir($targetDir)) {
            throw new \RuntimeException('Could not create upload folder. Check that public/uploads is writable.');
        }

        if (! is_writable($targetDir)) {
            throw new \RuntimeException('Upload folder is not writable: uploads/' . trim($directory, '/'));
        }

        $extension = strtolower($file->extension() ?: $file->getClientOriginalExtension() ?: 'jpg');
        $extension = preg_replace('/[^a-z0-9]+/', '', $extension) ?: 'jpg';

        $filename = Str::uuid() . '.' . $extension;
        $moved = $file->move($targetDir, $filename);

        if (! $moved || ! is_file($targetDir . DIRECTORY_SEPARATOR . $filename)) {
            throw new \RuntimeException('Could not save the uploaded image.');
        }

        return 'uploads/' . trim($directory, '/') . '/' . $filename;
    }

    public static function url(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $normalized = ltrim($path, '/');

        if (str_starts_with($normalized, 'uploads/') && is_file(public_path($normalized))) {
            return asset($normalized);
        }

        if (str_starts_with($normalized, 'storage/')) {
            $diskPath = Str::after($normalized, 'storage/');
            if (Storage::disk('public')->exists($diskPath)) {
                return asset('storage/' . $diskPath);
            }
        }

        if (Storage::disk('public')->exists($normalized)) {
            return asset('storage/' . $normalized);
        }

        if (is_file(public_path($normalized))) {
            return asset($normalized);
        }

        if (str_starts_with($normalized, 'images/') && is_file(public_path($normalized))) {
            return asset($normalized);
        }

        return null;
    }

    public static function delete(?string $path): void
    {
        if (! $path) {
            return;
        }

        $normalized = ltrim($path, '/');

        if (str_starts_with($normalized, 'uploads/')) {
            $fullPath = public_path($normalized);
            if (is_file($fullPath)) {
                unlink($fullPath);
            }

            return;
        }

        if (str_starts_with($normalized, 'storage/')) {
            Storage::disk('public')->delete(Str::after($normalized, 'storage/'));

            return;
        }

        if (Storage::disk('public')->exists($normalized)) {
            Storage::disk('public')->delete($normalized);
        }
    }
}
