<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

 class SkinLinuxV extends Skin {

  function SkinLinuxV() {
   
    $this->Skin(); // default init.
 
    global $sys_dir,$app_dir;
    $this->path_dir = "$sys_dir/Skins/LinuxV/";// path of templates
    $this->path_url = 'Skins/LinuxV/';         // URL useful for images and css
  }
}
?>
