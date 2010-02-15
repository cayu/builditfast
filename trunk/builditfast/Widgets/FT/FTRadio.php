<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds the FTRadio class
 * @package BIF3
 */


/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/FT/FTItem.php");

// {{{ class FTRadio
/**
 * Implements a FormRadio widget ready to be used as a FTItem.
 *
 * @package    BIF3
 * @subpackage Widgets/FT
 * @author     Nicolás D. César <ncesar@lunix.com.ar>
 * @version    $Revision: 1.2.6.3 $
 * @see        FTItem
 * @see        FormRadio
 */
class FTRadio extends FTItem {
  /** {{{ function FTRadio
   *
   * Instantiate a FTRadio widget.
   *
   * This contructor inherits attributes from FTItem: DESCRIPTION,
   * ITEM, HELP and ERROR and passes all the necessary attributes to
   * the FormRadio
   *
   * @parameter $attrs Instance's attributes specified as a hash in CAPS.
   */
  function __construct($attrs = array()) {
    $this->widgetName="ftitem";
    parent::__construct($attrs);

    $this->item =& new FormRadio($this->attributes);
  } // }}}
} // }}}

?>
