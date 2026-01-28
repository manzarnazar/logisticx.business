<?php

namespace App\Repositories\Upload;

interface UploadInterface
{

    public function upload($folder, $image_id, $new_image); //folder = folder name,image_id = existing image id , new_image = upload new image

    public function unlinkImage($image_id); //pass only image id

    public function uploadImage($image, $path, array $image_sizes = [], $old_upload_id = null);

    public function deleteImage($old_upload_id, $slug);

    function uploadSeederByPath(string $sourcePath = null, string $uploadDirectory = "assets", string $namePrefix = 'copy');
}
