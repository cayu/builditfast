<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file hold class SQLPara
 * @package BIF3
 */

/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/SQL/SQLVar.php");

// {{{ class SQLPara
/**
 * A paragraph taken from a sql database
 *
 * Table 'paragraphs' (default) holds all paragraphs' text.
 * You can set attribute TABLE iof you wish.
 *
 * @package    BIF3
 * @subpackage Widgets/Content
 * @author     Nicolas D. Cesar <ncesar@lunix.com.ar>
 * @version    $Revision: 1.1.2.1 $
 */
class SQLPara extends SQLVar {
  // {{{ function SQLVar
  /**
   * @parameter $attrs Instance's attributes specified as a hash with the 
following keys: (in CAPS!)
   * @parameter string TABLE table that holds paragraphs
   */
  function __construct($attrs = array()) {
    if (!  $attrs['TABLE'] ) {
      $attrs['TABLE'] = 'paragraphs';
    }
    parent::__construct($attrs);
  } // }}}
} // }}}

?>