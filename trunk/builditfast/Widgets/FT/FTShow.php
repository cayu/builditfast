<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds the FTShow class
 * @package BIF3
 */

/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/FT/FTItem.php");

// {{{ class BifText
/**
 * FT widget to show text and use a form hidden 
 * 
 * Use like FTText but unchangeable. It uses the same API.
 *
 * @package    BIF3
 * @subpackage Widgets/FT
 * @author     Nicolas Cesar <ncesar@lunix.com.ar>
 * @version    $Revision: 1.5.6.3 $
 * @see        FTItem
 * @see        FTText
 */
class FTShow extends FTItem {
  // {{{ function FTShow
  /**
   * Instantiate a FTShow widget.
   *
   * @parameter $attrs Instance's attributes specified as a hash in CAPS.
   */
  function __construct($attrs = array()) 
    {
      $this->widgetName='ftitem';
      parent::__construct($attrs);
    } // }}}

  function innerDraw()
    {
      $this->item =& new BifContainer;
      $text  =& new BifText(array('TEXT' => $this->attributes['VALUE']));
      $hidden =&  new FormHidden(array('NAME' =>  $this->attributes['NAME'],
				    'VALUE' =>  $this->attributes['VALUE']));
      $this->item->addChild($text);
      $this->item->addChild($hidden);

      parent::innerDraw();
    }
} // }}}

?>
