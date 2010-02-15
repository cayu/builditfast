<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 



/**
 * This file holds class FormPassword
 * @package  BIF3
 */
// {{{ class FormPassword
/**
 * Form's Password input
 *
 * This is a Basic form widget, HTML's <input type="password">
 * 
 * @package  BIF3
 * @subpackage Widgets/Basic
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.10.2.3 $
*/


class FormPassword extends BifWidget 
{
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string TEXT Text next to field (usually 'Password:')
   * @parameter string NAME Form's item's name
   * @parameter string VALUE Form's item's value
   * @parameter string SIZE Size of the field
   * @parameter string MAXLENGTH Maximum input lenght
   * @parameter string ALT Alternative, for tips
   */
  function __construct($attrs = array()) 
    {
      parent::__construct($attrs);
    }
 
  function innerDraw() 
    {
      $this->RAWfields=array("TEXT");
      $this->HTMLfields=array("NAME","VALUE","SIZE","MAXLENGTH","ALT");
    }
}
// }}}
?>
