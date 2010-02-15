<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds class SQLMenu
 * @package  BIF3
 */
// {{{ class SQLMenu
/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/SQL/SQLList.php");


/**
 * Menu drop down con CSS sin JavaScript y MySQL
 *
 * 
 * @package  BIF3
 * @subpackage Widgets/SQL
 * @author   Sergio Cayuqueo <linuxvarela@yahoo.com.ar>
 * @version  $Revision: 1.1.2.2 $
 */

class SQLMenu extends BifWidget {

  function __construct($attrs = array()) {
    if ( $attrs["WHERE"] ) { 
      $WHERE = " AND ( ". $attrs["WHERE"]  . " ) ";
    }
    $attrs['QUERY'] = "SELECT id,nombre,url FROM menu
    WHERE habilitado='1'  $WHERE order by id DESC";
    parent::__construct($attrs);
    }
}

?>
