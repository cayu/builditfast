<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class FormSubmit
 * @package  BIF3
 */
// {{{ class FormSubmit
/**
 * Form's submit button
 *
 * This is a Basic form widget, HTML's <input type="submit">
 * 
 * @package  BIF3
 * @subpackage Widgets/Basic
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.9.26.3 $
 */
class FormSubmit extends BifWidget 
{
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string NAME  Name of the item
   * @parameter string VALUE text to show (usually 'Send')
   * @parameter string LABEL text to show (usually 'Send')
   */
  function __construct($attrs = array()) 
    {
      parent::__construct($attrs);
    }
  
  function innerDraw() 
    {
      $this->HTMLfields=array("NAME","VALUE","LABEL");
    }
}
// }}}
?>