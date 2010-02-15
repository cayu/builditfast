<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 



/**
 * This file holds class FormSelect
 * @package  BIF3
 */
// {{{ class FormSelect
/**
 * Form's Selection 
 *
 * This is a Basic form widget, HTML's <select></select>
 * It should only have FormSelectItem childs!
 * 
 * Note: you can call method addOption(value, description, selected) 
 * to  add options to the selection.
 * 
 * @package  BIF3
 * @subpackage Widgets/Basic
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.11.16.3 $
 */

class FormSelect extends BifContainer 
{
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string NAME Select's name
   * @parameter string VALUE In case you need the selection in a specific value
   */
  function __construct($attrs = array()) 
    {
      parent::__construct($attrs);
    }
  // options that holds
  var $options =  array(); 
  // We want just one select;
  var $oneSelected = 0;

  function preChilds() 
    {
      $this->HTMLfields=array('NAME');

      
      if ($this->options == array()) {
	$this->tpl->setVariable('option_inserted',"");
      } else {
	do {
	  $this->tpl->setVariable('OPTION',$this->formatted());
	  $this->tpl->parse('option_inserted');
	}  while (next($this->options));
      }
      reset($this->options);
    }

  function addOption($value, $desc, $selected=false) 
    {
      array_push($this->options, array($value,$desc,$selected));
    }

  function formatted() 
    {
      $tmp = current($this->options);
      $value = $tmp[0];
      $desc = $tmp[1];

      if ($value==$this->attributes["VALUE"]) {
	$selected = true;
      } else {
	$selected = $tmp[2];
      }
      
      if ($selected AND ! $this->oneSelected) {
	$selected=' selected';
	$this->oneSelected = 1;
      } else {
	$selected="";
      }
      return "<option value=\"$value\"$selected>$desc</option>";
    }
}
// }}}
?>
