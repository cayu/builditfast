<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

function check_valid_ip($ip,$type = 'insert') {
  // TODO: implemnt valid IP check (get it from pear!)
  return true;
}

function check_valid_eth_mac($mac,$type = 'insert') {
  // TODO: implemnt valid IP check (get it from pear!)
  return true;
}

function check_valid_file($fileInfo,$type = 'insert') {
  /**
   * $fileInfo is an array:
   *
   * Array
   * (
   *    [name] => [user's given name]
   *    [type] => [MIME type]
   *    [tmp_name] => [tmp file name]
   *    [error] => [error code see: http://www.php.net/manual/en/features.file-upload.errors.php]
   *    [size] => [file size]
   * )
   */

  if ($fileInfo['error'] != 0) {
    return false;
  }

  if ($fileInfo['tmp_name'] == '') {
    return false;
  }
  return true;
}

function check_valid_user($string,$type = 'insert') {
  if (ereg('^[0-9A-Za-z_-]+$',$string)) {

    global  $bifcfg;

    if (!  $bifcfg['Auth']) {
      return false;
    };
    // Database table that holds autentication.
    if (! $bifcfg['Auth']['table']) {
      $table = "auth";
    } else {
      $table = $bifcfg['Auth']['table'];
    };
    $dsn = $bifcfg['Auth']['param'];

     // get user info from $dsn
    $db = DB::connect($dsn);
    if (DB::isError($db)) {
      bif_debug (__FILE__ . ' line <b>'. __LINE__ .'</b>: ' .
	    $db->getMessage() . " (dsn='$dsn')<br><br> " .
	    'Check <b>$bifcfg[\'Auth\']</b> in configuration file.');
      die();
    };

    $u = $string;
    $query = "select * from $table where username='$u'";
    $rst    = $db->query($query);
    if (DB::isError($rst)) {
      bif_debug (__FILE__ . ' line <b>'. __LINE__ .'</b>: ' .
	    $rst->getMessage() . " (dsn='$dsn')<br><br> ") ;
    }
    $cant   = $rst->numRows();
    if (DB::isError($cant)) {
      bif_debug (__FILE__ . ' line <b>'. __LINE__ .'</b>: ' .
	    $cant->getMessage() . " (dsn='$dsn')<br><br> ") ;
    }
	    
    if ($cant == 0) {
      if ($type == 'insert') {
	return true;
      }
    } else {
      if ($type == 'modify') {
	return true;
      }
    }
  } 
  return false; 
}

function check_alfanum($string,$type = 'insert') {
  if (ereg('^[ \.\,\'0-9A-Za-zñÑáÁéÉíÍóÓúÚäëïöüâêîôû:¿¡!\?#"\(\)\$\+=-]+$',$string)) 
    return true;
  else
    return false; 
}

function check_num($string,$type = 'insert') {
  if (ereg('^[0-9]+\.?[0-9]*$',$string)) 
    return true;
  else
    return false; 
}

function check_notnull_num($string,$type = 'insert') {
  if (isset($string) AND $string != '') {
    return check_num($string);
  } else {
    return false;
  }
}

function check_notzero_num($string,$type = 'insert') {
  if (isset($string) AND $string != 0) {
    return check_notnull_num($string);
  } else {
    return false;
  }
}

function check_notone_num($string,$type = 'insert') {
  if (isset($string) AND $string != 0) {
    return check_notnull_num($string);
  } else {
    return false;
  }
}

function check_notnull_alfanum($string,$type = 'insert') {
  if (isset($string) AND $string != '') {
    return check_alfanum($string);
  } else {
    return false;
  }
}

global $pear_dir;

require_once("$pear_dir/Validate.php");

function check_email($string,$type = 'insert') {
  return Validate::email($string);
}

function check_null_or_email($string,$type = 'insert') {
  if ($string == '') {
    return true;
  } else {
    return check_email($string);
  }
}

function check_url($string,$type = 'insert') {
  return Validate::url($string);
}

function check_null_or_url($string,$type = 'insert') {
  if ($string == '') {
    return true;
  } else {
    return check_url($string);
  }
}

function check_phone($string,$type = 'insert') {
  if (ereg('^[0-9]+-[0-9]+-[0-9]+-[0-9]*$',$string)) 
    return true;
  else
    return false; 
}

function check_null_or_phone($string,$type = 'insert') {
  if ($string == '' or  $string == '--') {
    return true;
  } else {
    return check_phone($string);
  }
}

?>
