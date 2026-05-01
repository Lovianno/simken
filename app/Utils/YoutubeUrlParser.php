<?php

namespace App\Utils;

class YoutubeUrlParser
{
  /**
   * Extracts the YouTube video ID from a given URL.
   * Supports various YouTube URL formats.
   *
   * @param string $url
   * @return string|null
   */
  public static function extractId(string $url): ?string
  {
    // Patterns for different YouTube URL formats
    $patterns = [
      '/youtu\.be\/([\w-]{11})/',
      '/youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=)([\w-]{11})/',
    ];
    foreach ($patterns as $pattern) {
      if (preg_match($pattern, $url, $matches)) {
        return $matches[1];
      }
    }
    return null;
  }
}
