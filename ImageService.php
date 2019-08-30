<?php

namespace App\Phoenix\Services\Image;

use File;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * @param $image
     * @param $folder_name
     * @param null $existing_image
     * @return string
     */
    public function uploadImage($image, $folder_name, $existing_image = null)
    {
        $image_name = $this->__getRandomNumbers().'_'.$image->getClientOriginalName();

        $file_path = 'images'.DIRECTORY_SEPARATOR.$folder_name.DIRECTORY_SEPARATOR.$image_name;
        Storage::disk('public')->put($file_path,  File::get($image));

        if($existing_image) {
            $this->__deleteFile('images'.DIRECTORY_SEPARATOR.$folder_name.DIRECTORY_SEPARATOR.$existing_image);
        }

        return $image_name;
    }


    public function delete($folder_name, $image_name)
    {
        $this->__deleteFile('images'.DIRECTORY_SEPARATOR.$folder_name.DIRECTORY_SEPARATOR.$image_name);
    }


    public function __deleteFile($file)
    {
        if(Storage::disk('public')->has($file)) {
            Storage::delete($file);
            return true;
        }

        return false;
    }

    /**
     * Get Random Number
     *
     * @return string
     */
    public function __getRandomNumbers()
    {
        return rand(5555, 9876).'_';
    }

}