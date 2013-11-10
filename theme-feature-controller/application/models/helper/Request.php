<?php

class ThemeFeatureController_Model_Helper_Request {

  public static function getParam($param, $default = null) {
    return isset($_POST[$param]) ? $_POST[$param] : (isset($_GET[$param]) ? $_GET[$param] : $default);
  }

  public static function getCurrentUrl() {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
      $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
      $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
  }

  public static function getCurrentPageUrl() {
    $pageUrl = self::getCurrentUrl();

    if(strpos($pageUrl, '?') === false)
      return $pageUrl;

    $tokens = explode('?', $pageUrl);

    $page_url = $tokens[0];

    $param_tokens = explode('&', $tokens[1]);

    foreach($param_tokens as $token)
      if(substr($token, 0, 4) == 'page')
        $page_url .= '?page' . substr($token, 4);

    return $page_url;
  }

  public static function copyDirectory($source, $dest, $permissions = 0755) {
    // Check for symlinks
    if (is_link($source)) {
      return symlink(readlink($source), $dest);
    }

    // Simple copy for a file
    if (is_file($source)) {
      return copy($source, $dest);
    }

    // Make destination directory
    if (!is_dir($dest)) {
      mkdir($dest, $permissions);
    }

    // Loop through the folder
    $dir = dir($source);
    while (false !== $entry = $dir->read()) {
      // Skip pointers
      if ($entry == '.' || $entry == '..') {
        continue;
      }

      // Deep copy directories
      xcopy("$source/$entry", "$dest/$entry");
    }

    // Clean up
    $dir->close();
    return true;
  }

}