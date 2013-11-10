<?php
/**
 * @author Andrei Robert Rusu
 * @throws Exception
 */
class ThemeFeatureController_Application {
  protected static $_instance;


  /**
   * Retrieve singleton instance
   *
   * @return ThemeFeatureController_Application
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

  /**
   * @var ThemeFeatureController_Model_Container
   */
  public $view;
  public $pluginInformation = array();

  public function __construct() {
    $this->view = new ThemeFeatureController_Model_Container();

    add_action( 'admin_menu', array($this, 'internalSetAdminMenu') );
  }

  public function internalSetAdminMenu() {
    add_menu_page( ThemeFeatureController_Model_Information::getInstance()->pluginName . ' | Index',
                   ThemeFeatureController_Model_Information::getInstance()->pluginName,
                   'manage_options',
                   ThemeFeatureController_Model_Information::getInstance()->pluginAlias,
                   array($this, 'indexAction'),
                  plugins_url(THEME_FEATURE_CONTROLLER_DIRECTORY_NAME . '/assets/img/menu-icon.png'));
  }

  public function init() {
    ThemeFeatureController_Model_Plugin::getInstance()->handleSetup();
  }

  public function indexAction() {
    if ( !current_user_can( 'manage_options' ) )  {
      wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }

    $currentAction = ThemeFeatureController_Model_Helper_Request::getParam('action', 'index');
    $currentPluginAlias = ThemeFeatureController_Model_Helper_Request::getParam('plugin_alias', '');

    if($currentAction == 'install') {
      $response = ThemeFeatureController_Model_Plugin::getInstance()->installPlugin($currentPluginAlias);

      if($response == true) {
        $this->view->success  = ThemeFeatureController_Model_Plugin::getInstance()->pluginInformation[$currentPluginAlias]['name'] . __(" has been successfully installed and activated");
      } else {
        $this->view->error = __("Plugin Installation Failed, your plugin may be already installed, or deleted");
      }
    } elseif($currentAction == 'activate') {
      $response = ThemeFeatureController_Model_Plugin::getInstance()->activatePlugin($currentPluginAlias);

      if($response == true) {
        $this->view->success  = ThemeFeatureController_Model_Plugin::getInstance()->pluginInformation[$currentPluginAlias]['name'] . __(" has been successfully activated");
      } else {
        $this->view->error = __("Plugin Activation Failed, your plugin may be already active, or deleted");
      }
    } elseif($currentAction == 'deactivate') {
      $response = ThemeFeatureController_Model_Plugin::getInstance()->deactivatePlugin($currentPluginAlias);

      if($response == true) {
        $this->view->success  = ThemeFeatureController_Model_Plugin::getInstance()->pluginInformation[$currentPluginAlias]['name'] . __(" has been successfully deactivated");
      } else {
        $this->view->error = __("Plugin Activation Failed, your plugin may be already deactivated, or deleted");
      }
    } elseif($currentAction == 'uninstall') {
      $response = ThemeFeatureController_Model_Plugin::getInstance()->uninstallPlugin($currentPluginAlias);

      if($response == true) {
        $this->view->success  = ThemeFeatureController_Model_Plugin::getInstance()->pluginInformation[$currentPluginAlias]['name'] . __(" has been successfully uninstalled");
      } else {
        $this->view->error = __("Plugin Activation Failed, your plugin may be already uninstalled, or deleted");
      }
    }

    $this->view->pluginInformation = ThemeFeatureController_Model_Plugin::getInstance()->pluginInformation;

    ThemeFeatureController_View::getInstance()->loadView('index.phtml', $this->view->getStorage());
  }

  public function errorAction() {
    ThemeFeatureController_View::getInstance()->loadView('error.phtml', $this->view->getStorage());
  }

}
