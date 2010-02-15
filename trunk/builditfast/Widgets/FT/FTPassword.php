<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds the FTPassword class
 * @package BIF3
 */


/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/FT/FTItem.php");

// {{{ class FTPassword
/**
 * Implements a password text field ready to use as a FTItem.
 *
 * @package    BIF3
 * @subpackage Widgets/FT
 * @author     Nicolás D. César <ncesar@lunix.com.ar>
 * @version    $Revision: 1.5.6.3 $
 * @see        FTItem
 */
class FTPassword extends FTItem {
  /** {{{ function FTPassword
   *
   * Instantiate a FTPassword widget.
   *
   * This constructor inherits attributes from FTItem: DESCRIPTION,
   * ITEM, HELP and ERROR.
   *
   * @parameter $attrs Instance's attributes specified as a hash in CAPS.
   * @parameter string TEXT Text next to field (usually 'Password:').
   * @parameter string NAME Form's item's name.
   * @parameter string VALUE Form's item's value.
   * @parameter string SIZE Size of the field.
   * @parameter string MAXLENGTH Maximum input length.
   * @parameter string ALT Alternative, for tips.
   */
  function __construct($attrs = array()) 
    {
      $this->widgetName='ftitem';
      parent::__construct($attrs);
    } // }}}

  function innerDraw()
    {
      $this->item =& new FormPassword(array('NAME' =>  $this->attributes['NAME'],
					'VALUE' =>  $this->attributes['VALUE'],
					'SIZE' => $this->attributes['SIZE'],
					'MAXLENGTH' => $this->attributes['MAXLENGTH'],
					'ALT' => $this->attributes['ALT']));
      parent::innerDraw();
    }
} // }}}

?>
