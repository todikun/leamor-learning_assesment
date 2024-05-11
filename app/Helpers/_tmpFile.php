<?php

namespace App\Helpers;

use App\Models\TmpFile;
use Illuminate\Support\Facades\File;

class _tmpFile {

    private static $path = 'tmp/';

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

    public static function moveFile($value)
    {
        $path = public_path(self::$path);
        $file = TmpFile::orderBy('id', 'asc')->get();
        foreach ($file as $item) {
            $tmp = $path.$item->name;
            if (in_array($item->name, $value) && file_exists($tmp)) {
                // move to dir uploads
                rename($tmp, public_path('uploads/') . $item->name);
            }
        }

        // Destroy temporary dir & file
        File::exists($path) ? File::deleteDirectory($path) : null;
        TmpFile::truncate();
    }
}