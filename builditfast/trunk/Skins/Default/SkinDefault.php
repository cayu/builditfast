<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 
class SkinDefault extends Skin {

  function __construct() {

    parent::__construct(); // default init.
    global $sys_dir,$app_dir;

    $this->path_dir = "$sys_dir/Skins/Default/";// path of templates
    $this->path_url = 'Skins/Default/';         // URL useful for images and css
    $this->reg =                                // Default values..
       array(
//	     'WidgetName_ATTRIBUTE' => 'value',  // Example
	     'titlebox_CELLSPACING' => '0',  
	     'titlebox_CELLPADDING' => '0',  
	     'titlebox_BORDER'      => '0',  
	     'titlebox_BGCOLOR' => '#DDDDDD',  
	     );
  }
}
?>