<?php

class ThemeFeatureController_Model_Information {

  protected static $_instance;

  /**
   * Retrieve singleton instance
   *
   * @return ThemeFeatureController_Model_Information
   */
  public static function getInstance()
  {
    if (null === self::$_instance) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  /**
   * Reset the singleton instance
   *
   * @return void
   */
  public static function resetInstance()
  {
    self::$_instance = null;
  }

  public $pluginName  = "Theme Controller";
  public $pluginAlias = "theme-controller";
  public $wpOptionPrefix = "theme-controller-option-";
}