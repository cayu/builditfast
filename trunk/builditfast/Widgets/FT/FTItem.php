<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds the FTItem class
 * @package BIF3
 */

// {{{ class FTItem
/**
 * This abstract class represents every item on a Form-table.
 *
 * @package    BIF3
 * @subpackage Widgets/FT
 * @author     Nicolás D. César <ncesar@lunix.com.ar>
 * @version    $Revision: 1.7.2.3 $
 */
class FTItem extends BifWidget {
  var $item;

  /** {{{ function FTItem
   *
   * Instantiate a FTLink widget
   *
   * @parameter $attrs Instance's attributes specified as a hash in CAPS.
   * @parameter string DESCRIPTION Form's field textual description.
   * @parameter string ITEM Usually a Form* widget to add to this item.
   * @parameter string HELP Help text to be shown on the last column.
   * @parameter string ERROR Error message in those cases where the data was badly entered.
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);

    if ( $this->attributes['DESCRIPTION'] == '') {
      if ( $this->attributes['NAME']) {
	$this->attributes['DESCRIPTION'] =  ucfirst(strtolower($this->attributes['NAME'])) . ': ';
      } else {
	$this->attributes['DESCRIPTION'] = '';
      }
    }
  } // }}}
 
  function innerDraw() {
    if (is_object($this->item)) {
      $this->attributes['ITEM'] = $this->item->draw();
    }

    $this->RAWfields=array('DESCRIPTION','ITEM','HELP','ERROR','NAME');
  }
} // }}}

?>