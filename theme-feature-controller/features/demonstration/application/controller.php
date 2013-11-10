<?php

class ClubixDemonstrationController {

  protected static $_instance;

  public static function getInstance() {
    if(self::$_instance == null)
      self::$_instance = new self();

    return self::$_instance;
  }

  public static function resetInstance() {
    self::$_instance = null;
  }

  /**
   * @var ClubixDemonstrationController
   */
  public $viewHelper;


  public function __construct() {
    require_once(ClubixDemonstrationBasePath . 'entities/shortcode/ShortCode.php');
    $this->_setViewHelper();

    $shortCodeInstance = new ClubixDemonstrationShortCode();

    add_shortcode( 'clubix_demo_typo'    ,array($shortCodeInstance , 'typo' ));
    add_shortcode( 'clubix_demo_elements',array($shortCodeInstance , 'elements' ));
  }

  public function runApplication() {
    // Init based
  }

  private function _setViewHelper() {
    require_once('viewHelper.php');
    $this->viewHelper = new ClubixDemonstrationViewHelper(ClubixDemonstrationBasePath);
  }

}