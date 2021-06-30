<?php


namespace App\Services;


use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageService
{
    public function addImg($img)
    {
        $filename = $img->getClientOriginalName();

        $img->move(Storage::path('public/image/feedbacks/') . 'origin/', $filename);

        $thumbnail = Image::make(Storage::path('public/image/feedbacks/') . 'origin/' . $filename);
        $thumbnail->fit(300, 300);
        $thumbnail->save(Storage::path('public/image/feedbacks/') . 'thumbnail/' . $filename);

        return $filename;
    }
}
