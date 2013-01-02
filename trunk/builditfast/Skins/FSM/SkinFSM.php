<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

class SkinFSM extends Skin {

  function SkinFSM() {
   
    $this->Skin(); // default init.
    global $sys_dir,$app_dir;

    $this->path_dir = "$sys_dir/Skins/FSM/";// path of templates
    $this->path_url = 'Skins/FSM/';         // URL useful for images and css
    $this->reg =                                // FSM values..
       array(
//	     'WidgetName_ATTRIBUTE' => 'value',  // Example
	'titlebox_WIDTH'  =>'100%',
	'titlebox2_WIDTH' =>'100%',
	'titlebox3_WIDTH' =>'100%',
	'titlebox4_WIDTH' =>'100%',
	     );
  }
}
?>
