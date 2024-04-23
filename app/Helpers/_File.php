<?php

namespace App\Helpers;

class _File {

    private static $path = 'uploads/';
    private static $tmp = 'tmp/';

    public static function uploadFile($file)
    {
        try {
            $fileName = rand(0000, 9999) . time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path(self::$path), $fileName);
            return $fileName;
        } catch (\Throwable $th) {
            dd($th);
            return null;
        }
    }

    public static function removeFile($file)
    {
        $existsFile = public_path(self::$path) . $file;
        if (file_exists($existsFile)) unlink($existsFile);
    }
}