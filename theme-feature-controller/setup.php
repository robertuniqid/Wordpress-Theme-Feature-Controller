<?php

define("THEME_FEATURE_CONTROLLER_DIRECTORY_NAME",
substr(dirname(__FILE__),strrpos(dirname(__FILE__),'/') + 1));

define("THEME_FEATURE_CONTROLLER_BASE_PATH",
    dirname(__FILE__).DIRECTORY_SEPARATOR);
define("THEME_FEATURE_CONTROLLER_APPLICATION_PATH",
    dirname(__FILE__).DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR);
define("THEME_FEATURE_CONTROLLER_FEATURES_PATH",
    dirname(__FILE__).DIRECTORY_SEPARATOR . 'features' . DIRECTORY_SEPARATOR);

require_once(THEME_FEATURE_CONTROLLER_APPLICATION_PATH . 'core/Loader.php');
require_once(THEME_FEATURE_CONTROLLER_APPLICATION_PATH . 'core/View.php');
require_once(THEME_FEATURE_CONTROLLER_APPLICATION_PATH . 'core/Handler.php');

ThemeFeatureController_Loader::getInstance()->load(THEME_FEATURE_CONTROLLER_APPLICATION_PATH . 'models' . DIRECTORY_SEPARATOR);

ThemeFeatureController_Application::getInstance()->init();
