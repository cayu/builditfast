<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

 class SkinLv extends Skin {

  function SkinLv() {
   
    $this->Skin(); // default init.
 
    global $sys_dir,$app_dir;
    $this->path_dir = "$sys_dir/Skins/Lv/";// path of templates
    $this->path_url = 'Skins/Lv/';         // URL useful for images and css
  }
}
?>
