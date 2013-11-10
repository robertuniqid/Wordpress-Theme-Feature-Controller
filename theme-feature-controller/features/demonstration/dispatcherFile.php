<?php

require_once('application/controller.php');

define('ClubixDemonstrationBasePath', dirname(__FILE__). DIRECTORY_SEPARATOR);

class ClubixDemonstrationDispatcher {

  public function run() {
    ClubixDemonstrationController::getInstance()->runApplication();
  }

  public function install() {
    // This action will run when your plugin will be installed
    // Keep in mind that the "activate" function will still run
  }

  public function uninstall() {
    // This action will run when your plugin will be un installed
    // Keep in mind that the "deactivate" function will still run if the plugin is active on uninstall
  }

  public function activate() {
    // This action will run when your plugin will be activated
  }

  public function deactivate() {
    // This action will run when your plugin will be deactivated
  }

}

$pluginInformation = array(
  'plugin_name'           =>  'Clubix Demonstration',
  'plugin_alias'          =>  'clubix-demonstration',
  'plugin_description'    =>
      'This plugin is the clubix demonstration helper, it will provide the shortcodes for the typo page and elements',
  'controller_class_name' =>  'ClubixDemonstrationDispatcher' // This is the Controller Class Name
);