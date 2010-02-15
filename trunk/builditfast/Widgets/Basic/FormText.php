<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class FormText
 * @package  BIF3
 */
// {{{ class FormText
/**
 * Form's Text input
 *
 * This is a Basic form widget, HTML's <input type="text">
 * 
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.8.26.3 $
 * @package  BIF3
 * @subpackage Widgets/Basic
 */
class FormText extends BifWidget 
{
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string TEXT Text next to field 
   * @parameter string NAME Form's item's name
   * @parameter string VALUE Form's item's value
   * @parameter string SIZE Size of the field
   * @parameter string MAXLENGTH Maximum input lenght
   * @parameter string ALT Alternative, for tips
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);
  }
 
  function innerDraw() {
    $this->RAWfields=array("TEXT");
    $this->HTMLfields=array("NAME","VALUE","SIZE","MAXLENGTH","ALT");
  }
}
// }}}
?>
