<?php

namespace App\Utils;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;

class ImageCompressor
{
  /**
   * Compress and resize an uploaded image for thumbnail usage.
   *
   * @param UploadedFile $file
   * @param int $width
   * @param int $height
   * @param int $quality
   * @return string Path to the stored compressed image
   */
  public static function compressThumbnail(UploadedFile $file, int $width = 360, int $height = 240, int $quality = 75): string
  {
    $manager = new ImageManager(new Driver());
    $image = $manager->read($file->getRealPath())
      ->cover($width, $height)
      ->toWebp(quality: $quality);

    $filename = 'thumb_' . Str::random(16) . '.webp';
    $path = 'course-thumbnails/' . $filename;
    $fullPath = storage_path('app/public/' . $path);

    // Pastikan direktori tujuan ada
    if (!is_dir(dirname($fullPath))) {
      mkdir(dirname($fullPath), 0755, true);
    }

    file_put_contents($fullPath, (string) $image);

    return $path;
  }
}
