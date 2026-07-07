<?php

namespace App\Services;

use Cloudinary\Cloudinary;

class CloudinaryService
{
    protected $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary(env('CLOUDINARY_URL'));
    }

    public function upload($file, $folder = 'undangan-digital', $resourceType = 'image')
    {
        $result = $this->cloudinary->uploadApi()->upload($file->getRealPath(), [
            'folder' => $folder,
            'resource_type' => $resourceType,
        ]);

        return $result['secure_url']; // ini URL yang akan disimpan ke database
    }

    public function delete($url)
    {
        $publicId = $this->extractPublicId($url);
        $resourceType = $this->extractResourceType($url);
        $this->cloudinary->uploadApi()->destroy($publicId, ['resource_type' => $resourceType]);
    }

    protected function extractResourceType($url)
    {
        $parts = explode('/', parse_url($url, PHP_URL_PATH));
        return $parts[2] ?? 'image';
    }

    protected function extractPublicId($url)
    {
        $parts = explode('/', parse_url($url, PHP_URL_PATH));
        array_shift($parts); // buang bagian kosong di awal
        array_shift($parts); // buang cloud_name
        array_shift($parts); // buang resource_type (image/video)
        array_shift($parts); // buang type (upload)
        array_shift($parts); // buang versi (misal v123456)
        $path = implode('/', $parts);
        return pathinfo($path, PATHINFO_DIRNAME) . '/' . pathinfo($path, PATHINFO_FILENAME);
    }
}