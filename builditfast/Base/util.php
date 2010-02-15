<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

function util_get_username() {
  return $_SESSION['_BifApplication']->getVar('user_username');
}

// includes all .php available in $dir
function includeDotPHP($dir){
  $handle=opendir($dir);
  while ($file = readdir($handle)){
    $completepath=$dir.'/'.$file;
    if (ereg("^[^#]*php\$",$file)) {       
      bif_debug("Automatic require:'$completepath'",4);
      require_once($completepath);
    }else{
      if (is_dir($completepath) and 
	  $file != '.' and 
	  $file != '..'){
	includeDotPHP($completepath);
      }
    }
  }
  closedir($handle); 
} 

// includes sys and (if exists) app objects 
function includeSysAndApp($name) {
  global $sys_dir,$app_dir;
  includeDotPHP("$sys_dir/$name");
  if ($sys_dir != $app_dir) {
    if (is_dir("$app_dir/$name")) {
      includeDotPHP("$app_dir/$name");
    }
  }
}

function file_exists_in($file,$dirs) {

  if(is_string($dirs)) {
    $dirs=explode(',',$dirs);
  }

  do {
    $dir = array_pop($dirs);
  } while (! file_exists("$dir/$file") && ! empty($dirs));

  if (file_exists("$dir/$file")) {
    return "$dir/$file";
  } else { 
    return "";
  }
}

function util_file_get_contents($fileInfo) {
  $ret = file_get_contents($fileInfo['tmp_name']);
  bif_debug("util_file_get_contents(): \n$ret",3);
  return $ret;
}

?>