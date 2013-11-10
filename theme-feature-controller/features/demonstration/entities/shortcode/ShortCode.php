<?php

class ClubixDemonstrationShortCode {

  public function __construct() {

  }

  public function typo($atts) {
    return ClubixDemonstrationController::getInstance()->viewHelper->partial('typo.phtml');
  }

  public function elements($atts) {
    return ClubixDemonstrationController::getInstance()->viewHelper->partial('elements.phtml');
  }

}