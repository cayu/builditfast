<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

global $sys_dir;
require_once("$sys_dir/Components/FileUpload.php");
class ImageUpload  extends FileUpload{ 

  var $defaultdir = 'images/'; // directory with WRITE access

  function __construct($id,$attrs){
    parent::__construct($id,$attrs);
  }

  function check() {
    global $_FILES;
    if (ereg("image",$_FILES['userfile']['type'])) {
      return true;
    } else {
      return false;
    }
  }

}
?>
