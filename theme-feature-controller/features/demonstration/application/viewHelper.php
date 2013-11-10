<?php

class ClubixDemonstrationViewHelper {
  private $_partial_directory = 'layout/partial/';
  private $_partial_path    = '';

  public function __construct($pluginPath) {
    $this->_partial_path = $pluginPath . $this->_partial_directory;
  }

  public function partial($file, $variables = array()){
    if(!is_array($variables))
      throw new Exception("Partial included variables must be an array");

    extract($variables);
    ob_start();

    require($this->_partial_path . $file);

    $return_html = ob_get_contents();
    ob_end_clean();

    return $return_html;
  }
}