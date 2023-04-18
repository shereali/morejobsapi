<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileHandleService
{
    public static function upload($file, $path = null)
    {
        return $file->store($path);
    }

    public static function delete($filePath)
    {
        Storage::delete($filePath);
    }

    public static function getAvatarStoragePath(): string
    {
        return '/avatars';
    }

    public static function getResumeStoragePath(): string
    {
        return '/resumes/' .  AuthService::getAuthUserId();
    }

    public static function getBlogStoragePath(): string
    {
        return '/blogs';
    }

    public static function getCompanyLogoStoragePath(): string
    {
        return '/company-images';
    }

    public static function getCompanyPath($id): string
    {
        return '/companies/' . $id;
    }

    public static function getAdsStoragePath(): string
    {
        return '/app-ads';
    }
}
