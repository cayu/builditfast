<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds the FTText class
 * @package BIF3
 */

/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/SQL/SQLSelect.php");
require_once("$sys_dir/Widgets/FT/FT.php");

// {{{ class FTSQLSelect
/**
 * Form-table item describing a 'select' from a SQL query
 * 
 * simple example
 * <FTSQLSelect name="names" query="select id,name from table" />
 *
 * @package    BIF3
 * @subpackage Widgets/FT
 * @author     Nicolás D. César <ncesar@lunix.com.ar>
 * @version    $Revision: 1.1.2.1 $
 * @see        FTItem
 * @see        FormSelect
 */
class FTSQLSelect extends FT {

  function __construct($attrs = array()) 
    {
      $this->widgetName='ftitem';
      parent::__construct($attrs);
    } //}}}

  function innerDraw()
    {
      $this->item =& new SQLSelect(array('NAME' =>  $this->attributes['NAME'],
					   'VALUE' =>  $this->attributes['VALUE'],
					   'QUERY' => $this->attributes['QUERY'],
					   'EXTRA' => $this->attributes['EXTRA'],
					   ));
      parent::innerDraw();
    }
} // }}}
?>
