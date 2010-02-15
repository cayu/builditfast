<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class FormSelectionItem
 * @package  BIF3
 */
// {{{ class FormSelectionItem
/**
 * Form's Selection Item
 *
 * This is a Basic form widget, HTML's <option></option>
 * Note: This class can only be used together with FormSelect
 * 
 * @package  BIF3
 * @subpackage Widgets/Basic
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.7.26.3 $
*/
class FormSelectItem extends BifWidget 
{
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string DESC  Text to be shown
   * @parameter string VALUE Value that will take the FormSelect
   * @parameter string SELECTED initially selected
   * @parameter string CHECKED initially selected
   */
  function __construct($attrs = array()) 
    {
      parent::__construct($attrs);
    }
  
  function innerDraw() 
    {
      $this->RAWfields=array("DESC");
      $this->HTMLfields=array("VALUE");

      if ($this->attributes["SELECTED"] || $this->attributes["CHECKED"])
	$this->tpl->setVariable("SELECTED", " selected");
      else 
	$this->tpl->setVariable("SELECTED", "");
    }
}
// }}}
?>