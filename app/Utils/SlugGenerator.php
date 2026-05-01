<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SlugGenerator
{
  /**
   * Generate unique slug for a model.
   *
   * @param  class-string<Model>  $modelClass
   * @param  string  $baseSlug
   * @param  string  $column
   * @return string
   */
  public static function generate(string $modelClass, string $baseSlug, string $column = 'slug'): string
  {
    $slug = Str::slug($baseSlug);
    $i = 2;
    while ($modelClass::where($column, $slug)->exists()) {
      $slug = $baseSlug . '-' . $i;
      $i++;
    }
    return $slug;
  }
}
