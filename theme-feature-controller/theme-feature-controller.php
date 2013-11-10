<?php
/*
Plugin Name: Theme Feature Controller
Description: Theme Feature Controller
Version: 1.0
Plugin URI: http://easy-development.com
Author: Andrei-Robert Rusu
Author URI: http://easy-development.com
*/

require_once('setup.php');

register_activation_hook(__FILE__, array(ThemeFeatureController_Application::getInstance(), 'internalActivate'));
register_deactivation_hook (__FILE__, array(ThemeFeatureController_Application::getInstance(), 'internalDeActivate'));