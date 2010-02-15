<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class FormRadio
 * @package  BIF3
 */
// {{{ class FormRadio
/**
 * Form's Radio buttons
 *
 * This is a Basic form widget, HTML's <input type="radio">
 * Note: All FormRadios should have the same NAME 
 * 
 * @package  BIF3
 * @subpackage Widgets/Basic
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.7.26.3 $
 */
class FormRadio extends BifWidget 
{
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string DESC  Radio button's description. (It's some text next to it)
   * @parameter string NAME  Variable's name
   * @parameter string VALUE default value
   * @parameter string ALT alt
   * @parameter string SELECTED  selects the button.
   * @parameter string CHECKED selects the button.
   */ 
  function __construct($attrs = array()) 
    {
      parent::__construct($attrs);
    }
  
  function innerDraw() 
    {
      $this->RAWfields=array("DESC");
      $this->HTMLfields=array("NAME","VALUE","ALT");
      
      if ($this->attributes["SELECTED"] || $this->attributes["CHECKED"])
	$this->tpl->setVariable("CHECKED", " checked");
      else 
	$this->tpl->setVariable("CHECKED", "");
    }
}
// }}}
?>