<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class FormURL
 * @package  BIF3
 */
// {{{ class FormURL
/**
 * Form's URL input
 *
 * This is a Basic form widget, HTML's <input type="TEXT"> with a 'http://' inserted
 * in the future some validatons (javascript I guess will be added)
 * 
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.1.16.3 $
 * @package  BIF3
 * @subpackage Widgets/Basic
 */
class FormURL extends BifWidget 
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

    if ($this->attributes["VALUE"] == "") {
      $this->attributes["VALUE"] = "http://";
    }

    $this->RAWfields=array("TEXT");
    $this->HTMLfields=array("NAME","VALUE","SIZE","MAXLENGTH","ALT");
  }
}
// }}}
?>
