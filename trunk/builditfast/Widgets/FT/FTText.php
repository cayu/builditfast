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
require_once("$sys_dir/Widgets/FT/FTItem.php");

// {{{ class FTText
/**
 * Form-table item describing simple text field.
 *
 * @package    BIF3
 * @subpackage Widgets/FT
 * @author     Nicolás D. César <ncesar@lunix.com.ar>
 * @version    $Revision: 1.9.6.3 $
 * @see        FTItem
 * @see        FormText
 */
class FTText extends FTItem {
  /** {{{ function Constructor
   *
   * Instantiate a FTText widget.
   *
   * This constructor inherits attributes from FTItem: DESCRIPTION,
   * ITEM, HELP and ERROR.
   *
   * @parameter $attrs Instance's attributes specified as a hash in CAPS.
   * @parameter string NAME The field's name, to be used as a variable name.
   * @parameter string VALUE Field's default value.
   * @parameter string SIZE Field's size in chars.
   * @parameter string MAXLENGTH Field's maximum number of accepted chars.
   * @parameter string ALT FIXME: what's this?
   */
  function __construct($attrs = array()) 
    {
      $this->widgetName='ftitem';
      parent::__construct($attrs);
    } // }}}

  function innerDraw()
    {
      $this->item =& new FormText(array('NAME' =>  $this->attributes['NAME'],
					'VALUE' =>  $this->attributes['VALUE'],
					'SIZE' => $this->attributes['SIZE'],
					'MAXLENGTH' => $this->attributes['MAXLENGTH'],
					'ALT' => $this->attributes['ALT']));
      parent::innerDraw();
    }
} // }}}

?>
