<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class FormTextarea
 * @package  BIF3
 */
// {{{ class FormTextarea
/**
 * Form's Text Area
 *
 * This is a Basic form widget
 * 
 * @package  BIF3
 * @subpackage Widgets/Basic
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.11.26.3 $
 */
class FormTextarea extends BifContainer 
{
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string TEXT text near textarea explaining
   * @parameter string NAME name of the variable
   * @parameter string VALUE Initial text inside text area
   * @parameter string COLS cols
   * @parameter string ROWS rows
   */
  function __construct($attrs = array()) 
    {
      parent::__construct($attrs);
    }
 
  function preChilds() //actions to take _before_ parsing all childs 
    {
      $this->RAWfields=array('TEXT','VALUE');
      $this->HTMLfields=array('NAME','COLS','ROWS');
    }
}
// }}}
?>
