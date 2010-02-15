<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class FormCheckbox
 * @package  BIF3
 */
// {{{ class FormCheckbox
/**
 * Form's Checkbox
 *
 * This is a Basic form widget, HTML's <input type="checkbox">
 * 
 * @package  BIF3
 * @subpackage Widgets/Basic
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.10.26.3 $
*/
class FormCheckbox extends BifWidget 
{
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string NAME Name of the check box
   * @parameter string TEXT Text next to the checkbox
   * @parameter void SELECTED Show checkbox checked
   * @parameter void  CHECKED Show checkbox checked
   * @parameter string VALUE 'on' or 'off'
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);
  }
 
  function innerDraw() {
    $this->HTMLfields=array("NAME");
    $this->RAWfields=array("TEXT");

    if ($this->attributes["SELECTED"] == "FALSE" || $this->attributes["CHECKED"] == "FALSE") {
      unset($this->attributes["SELECTED"]);
      unset($this->attributes["CHECKED"]);
    }
    if ($this->attributes["SELECTED"]
	|| $this->attributes["CHECKED"]
	|| $this->attributes["VALUE"] == 'on')
      $this->tpl->setVariable("CHECKED","CHECKED");
    else 
      $this->tpl->setVariable("CHECKED","");
  }
}
// }}}
?>