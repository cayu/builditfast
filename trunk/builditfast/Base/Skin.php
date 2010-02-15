<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


class Skin extends PEAR {

  var $reg = array();

  function __construct() {

    parent::PEAR(); // default init.
    global $sys_dir,$app_dir;

    $this->path_dir = '$sys_dir/Skins/Default/';// path of templates
    $this->path_url = 'Skins/Default/';         // URL useful for images and css
    $this->reg =                                // Default values..
       array(
//	     'WidgetName_ATTRIBUTE' => 'value',  // Example

	     );
  }

  function __destruct() {
    // Destructor
  }

  function resource($string,$type='_template') {
    if ($type == '_template') {
      $file = $this->path_dir . $string . '.tpl';
      if (file_exists($file)) {
	return($file);
      }else{
	return;
      }
    } 
    else if ($type == '_css') {
      $file= $this->path_url . 'css/' . $string . '.css';
      global $app_dir;
      if (file_exists($file)) {
	return($file);
      }else{
	return;
      }
    }
    else
      return $this->reg[$string . $type];
  }

}
?>