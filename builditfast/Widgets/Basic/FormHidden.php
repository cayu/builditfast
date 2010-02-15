<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class FormHidden
 * @package  BIF3
 */
// {{{ class FormHidden
/**
 * Form's Hidden
 *
 * This is a Basic form widget, HTML's <input type="hidden">
 * 
 * @package  BIF3
 * @subpackage Widgets/Basic
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.7.26.3 $
 */
class FormHidden extends BifWidget 
{
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string NAME Form's item's name
   * @parameter string VALUE Form's item's value
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);
  }
  function innerDraw() {
    $this->HTMLfields=array("NAME","VALUE");
  }
}
// }}}
?>