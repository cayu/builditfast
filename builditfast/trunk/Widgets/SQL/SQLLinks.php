<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file hold class SQLLinks
 * @package BIF3
 */

/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/SQL/SQLList.php");

// {{{ class SQLLinks
/**
 * Links table. Based in SQLList
 * 
 * @package  BIF3
 * @subpackage Widgets/SQL
 * @author   Sergio Cayuqueo <linuxvarela@yahoo.com.ar>
 * @version  $Revision: 1.1.2.1 $
 */
class SQLLinks extends SQLList {
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string WHERE an aditional restriction.
   */
  function __construct($attrs = array()) {
    if ( $attrs["WHERE"] ) { 
      $WHERE = " AND ( ". $attrs["WHERE"]  . " ) ";
    }
    $attrs['QUERY'] = "SELECT id,nombre,url,descripcion FROM links
    WHERE habilitado='1'  $WHERE order by id DESC";
    parent::__construct($attrs);
  }// }}}
}// }}}
?>