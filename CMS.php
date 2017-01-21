<?php

class CMS {
  public static function startsWith($haystack, $needle) {
      // search backwards starting from haystack length characters from the end
      return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
  }

  public static function endsWith($haystack, $needle) {
      // search forward starting from end minus needle length characters
      return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
  }

  public static function startsWithVowel($haystack) {
      // search backwards starting from haystack length characters from the end
      $vowels = array('a', 'e', 'i', 'o', 'u');

      foreach($vowels as $vowel) {
        if(self::startsWith($haystack, $vowel) || self::startsWith($haystack, strtoupper($vowel))) {
          return true;
        }
      }
      return false;
  }
}
