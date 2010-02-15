#!/bin/sh

for a in $* 
do 
	mkdir -p "$a"	
	cat > "$a/Skin$a.php" << EOF
<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

 class Skin$a extends Skin {

  function __construct() {

    parent::__construct(); // default init.   
 
    global \$sys_dir,\$app_dir;
    \$this->path_dir = "\$sys_dir/Skins/$a/";// path of templates
    \$this->path_url = 'Skins/$a/';         // URL useful for images and css
  }
}
?>
EOF
done 
