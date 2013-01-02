<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

class SkinAvina extends Skin{

  function SkinAvina() {
   
    $this->Skin(); // default init.
    global $sys_dir,$app_dir;

    $this->path_dir = "$app_dir/Skins/Avina/";// path of templates
    $this->path_url = 'Skins/Avina/';         // URL useful for images and css
    $this->reg =                                // Avina values..
       array(
//	     'WidgetName_ATTRIBUTE' => 'value',  // Example
	     'lateral_WIDTH' => '250',
	     );
  }
}
?>
