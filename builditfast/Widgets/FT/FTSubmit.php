<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds the FTSubmit class
 * @package BIF3
 */

/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/FT/FTItem.php");

// {{{ class FTSubmit
/**
 * Form-table item describing a submit button
 *
 * @package    BIF3
 * @subpackage Widgets/FT
 * @author     Nicolás D. César <ncesar@lunix.com.ar>
 * @version    $Revision: 1.10.6.3 $
 * @see        FTItem
 * @see        FormSubmit
 */
class FTSubmit extends FTItem {
  /** {{{ function Constructor
   *
   * Instantiate a FTSubmit widget.
   *
   * This constructor inherits attributes from FTItem: DESCRIPTION,
   * ITEM, HELP and ERROR.
   *
   * @parameter $attrs Instance's attributes specified as a hash in CAPS.
   * @parameter string NAME Name of the item
   * @parameter string VALUE text to show (usually 'Send')
   * @parameter string LABEL text to show (usually 'Send')
   */
  function __construct($attrs = array()) {
    $this->widgetName='ftitem';
    parent::__construct($attrs);
  } // }}}

  function innerDraw(){
    $this->attributes['DESCRIPTION'] = '&nbsp;';
    $this->item =& new FormSubmit(array(
					'NAME' =>  $this->attributes['NAME'],
					'VALUE' =>  $this->attributes['VALUE'], 
					'LABEL' =>  $this->attributes['LABEL'], 
					));
    parent::innerDraw();
  }
} // }}}

?>
