<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds the FTSelect class
 * @package BIF3
 */

/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/FT/FTItem.php");

// {{{ class FTSelect
/**
 * Implements a FormSelect ready to use inside a FT.
 *
 * @package    BIF3
 * @subpackage Widgets/FT
 * @author     Nicolás D. César <ncesar@lunix.com.ar>
 * @version    $Revision: 1.10.6.3 $
 * @see        FTItem
 * @see        FormSelect
 */
class FTSelect extends FTItem {
  /** {{{ function FTSelect
   *
   * Instantiate a FTSelect widget.
   *
   * This constructor inherits attributes from FTItem: DESCRIPTION,
   * ITEM, HELP and ERROR.
   *
   * @parameter $attrs Instance's attributes specified as a hash in CAPS.
   */
  function __construct($attrs = array()) {    
    $this->widgetName='ftitem';
    parent::__construct($attrs);

    $this->item =& new FormSelect($this->attributes);
  } // }}}

  /** {{{ function addOption
   * 
   * Add option to options list on select widget
   *
   * @parameter string value Option's real value.
   * @parameter string desc Option's description (appears on the page).
   * @parameter bool selected True if this option should be selected (Default: false).
   */
  function addOption($value, $desc, $selected=false) {
    $this->item->addOption($value, $desc, $selected);
  } // }}}

  function addChild(&$obj) {
    $this->item->addChild($obj);
  }
} // }}}

?>
