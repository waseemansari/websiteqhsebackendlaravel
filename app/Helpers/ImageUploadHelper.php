<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Auth;
use App\Models\Branch;
class ImageUploadHelper
{
    public static function uploadAndResize($file, $folder, $width = null, $height = null)
    {
        $branch_id = Auth::user()->branch_id ?? 0;
        
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = Str::random(10) . '.' . $extension;
        $path = "website/{$branch_id}/{$folder}/{$filename}";
 
        // Allowed image extensions
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        $result = Storage::disk('spaces')->putFileAs(
                "website/public/images/{$branch_id}/{$folder}",
                $file,
                $filename,
                'public'
            );

        return $result;
    }
}
