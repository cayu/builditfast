<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds the FTLink class
 * @package BIF3
 */


/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/FT/FTItem.php");

// {{{ class FTLink
/**
 * Implements a BifLink widget ready to be used as a FTItem.
 *
 * @package    BIF3
 * @subpackage Widgets/FT
 * @author     Nicolás D. César <ncesar@lunix.com.ar>
 * @version    $Revision: 1.5.6.3 $
 * @see        FTItem
 */
class FTLink extends FTItem {
  /** {{{ function FTLink
   *
   * Instantiate a FTLink widget.
   *
   * This constructor inherits attributes from FTItem: DESCRIPTION,
   * ITEM, HELP and ERROR.
   *
   * @parameter $attrs Instance's attributes specified as a hash in CAPS.
   * @parameter string TEXT Link's text.
   * @parameter string HREF Link's URL destination.
   * @parameter string TARGET Link's target.
   */
  function __construct($attrs = array()) 
    {
      $this->widgetName='ftitem';
      parent::__construct($attrs);
    } // }}}

  function innerDraw()
    {
      $this->item =& new BifLink(array('TEXT' => $this->attributes['TEXT'],
				       'HREF' => $this->attributes['HREF'],
				       'TARGET' => $this->attributes['TARGET']));
      parent::innerDraw();
    }
} // }}}

?>
