<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadTrait
{
    /**
     * Upload one file to storage.
     *
     * @param  UploadedFile  $uploadedFile
     * @param  string        $folder
     * @param  string        $disk
     * @param  string        $filename
     * @return UploadedFile
     */
    public function uploadOne(UploadedFile $uploadedFile, string $folder = null, string $disk = 'public', string $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25);
        $file = $uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->getClientOriginalExtension(), $disk);

        return $file;
    }
    
    /**
     * Upload one file from url to storage.
     *
     * @param  string  $url
     * @param  string  $folder
     * @param  string  $filename
     * @return bool
     */
    public function uploadFromUrl(string $url, string $folder, string $filename)
    {
        $info = pathinfo($url);
        $extension = $info['extension'];
        $contents = file_get_contents($url);
        Storage::put($folder.$filename.'.'.$extension, $contents);

        return true;
    }
}