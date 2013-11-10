<?php

class ThemeFeatureController_Model_Plugin {

  protected static $_instance;

  /**
   * Retrieve singleton instance
   *
   * @return ThemeFeatureController_Model_Plugin
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

  public $pluginInformation = array();

  public function __construct() {
    $this->_setPluginList();
  }

  public function handleSetup() {
    foreach($this->pluginInformation as $plugin) {
      if($plugin['is_active'] == true)
        $plugin['object']->run();
    }
  }

  public function installPlugin($plugin_alias) {
    if(isset($this->pluginInformation[$plugin_alias])) {
      if($this->pluginInformation[$plugin_alias]['is_installed'] == true)
        return false;

      if(method_exists($this->pluginInformation[$plugin_alias]['object'], 'install'))
        $this->pluginInformation[$plugin_alias]['object']->install();

      $this->pluginInformation[$plugin_alias]['is_installed'] = true;

      update_option(ThemeFeatureController_Model_Information::getInstance()->wpOptionPrefix . $plugin_alias . '-is-installed', 1);

      $this->activatePlugin($plugin_alias);
      return true;
    }

    return false;
  }

  public function uninstallPlugin($plugin_alias) {
    if(isset($this->pluginInformation[$plugin_alias])) {
      if($this->pluginInformation[$plugin_alias]['is_installed'] == false)
        return false;

      if($this->pluginInformation[$plugin_alias]['is_active'] == true)
        $this->DeActivatePlugin($plugin_alias);

      if(method_exists($this->pluginInformation[$plugin_alias]['object'], 'uninstall'))
        $this->pluginInformation[$plugin_alias]['object']->uninstall();

      $this->pluginInformation[$plugin_alias]['is_installed'] = false;

      delete_option(ThemeFeatureController_Model_Information::getInstance()->wpOptionPrefix . $plugin_alias . '-is-active');
      delete_option(ThemeFeatureController_Model_Information::getInstance()->wpOptionPrefix . $plugin_alias . '-is-installed');
      return true;
    }

    return false;
  }

  public function activatePlugin($plugin_alias) {
    if(isset($this->pluginInformation[$plugin_alias])) {
      if($this->pluginInformation[$plugin_alias]['is_active'] == true)
        return false;

      if(method_exists($this->pluginInformation[$plugin_alias]['object'], 'activate'))
        $this->pluginInformation[$plugin_alias]['object']->activate();

      $this->pluginInformation[$plugin_alias]['is_active'] = true;

      update_option(ThemeFeatureController_Model_Information::getInstance()->wpOptionPrefix . $plugin_alias . '-is-active', 1);
      return true;
    }

    return false;
  }

  public function deactivatePlugin($plugin_alias) {
    if(isset($this->pluginInformation[$plugin_alias])) {
      if($this->pluginInformation[$plugin_alias]['is_active'] == false)
        return false;

      if(method_exists($this->pluginInformation[$plugin_alias]['object'], 'deactivate'))
        $this->pluginInformation[$plugin_alias]['object']->deactivate();

      $this->pluginInformation[$plugin_alias]['is_active'] = false;

      update_option(ThemeFeatureController_Model_Information::getInstance()->wpOptionPrefix . $plugin_alias . '-is-active', 0);

      return true;
    }

    return false;
  }

  public function isActive($plugin_alias) {
    return get_option(ThemeFeatureController_Model_Information::getInstance()->wpOptionPrefix . $plugin_alias . '-is-active', false);
  }

  public function isInstalled($plugin_alias) {
    return get_option(ThemeFeatureController_Model_Information::getInstance()->wpOptionPrefix . $plugin_alias . '-is-installed', false);
  }

  private function _setPluginList() {
    $directoryList = array();

    $directories = scandir(THEME_FEATURE_CONTROLLER_FEATURES_PATH);

    foreach($directories as $directory){
      if(
        !in_array($directory, array('.', '..'))
        && is_dir(THEME_FEATURE_CONTROLLER_FEATURES_PATH . $directory)
      ){
        $directoryList[] = $directory;
      }
    }

    $pluginListInformation = array();

    foreach($directoryList as $directory) {
      require_once(THEME_FEATURE_CONTROLLER_FEATURES_PATH . $directory . DIRECTORY_SEPARATOR . 'dispatcherFile.php');

      if(isset($pluginInformation)) {
        $pluginListInformation[$pluginInformation['plugin_alias']] = array(
          'name'         =>  $pluginInformation['plugin_name'],
          'alias'        =>  $pluginInformation['plugin_alias'],
          'description'  =>  $pluginInformation['plugin_description'],
          'is_active'    =>  $this->isActive($pluginInformation['plugin_alias']),
          'is_installed' =>  $this->isInstalled($pluginInformation['plugin_alias']),
          'object'       =>  new $pluginInformation['controller_class_name']
        );

        unset($pluginInformation);
      }
    }

    $this->pluginInformation = $pluginListInformation;
  }
}