<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds the FTTextarea class
 * @package BIF3
 */

/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/FT/FTItem.php");

// {{{ class FTTextarea
/**
 * Form-table item describing a text area.
 *
 * @package    BIF3
 * @subpackage Widgets/FT
 * @author     Nicolás D. César <ncesar@lunix.com.ar>
 * @version    $Revision: 1.13.6.3 $
 * @see        FTItem
 * @see        FormTextarea
 */
class FTTextarea extends FTItem {
  // {{{ function Constructor 
  /** 
   *
   * Instantiate a FTTextarea widget.
   *
   * This constructor inherits attributes from FTItem: DESCRIPTION, 
   * ITEM, HELP and ERROR.
   * 
   * @parameter $attrs Instance's attributes specified as a hash in CAPS.
   */
  function __construct($attrs = array()) {
    $this->widgetName='ftitem';
    parent::__construct($attrs);
    $this->item =& new FormTextarea($this->attributes);
  } // }}}


  function addChild($obj) {
    $this->item->addChild($obj);
  }
} // }}}
?>
