<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class FormCnt
 * @package  BIF3
 */
// {{{ class FormCnt
/**
 * Form Container, Should only have Form* Widgets as children
 *
 * This is a Basic form container for multiples uses, 
 * consider using FT* widgets for creating visual Forms 
 * 
 * @package  BIF3
 * @subpackage Widgets/Basic
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.9.26.3 $
 */

class FormCnt extends BifContainer 
{
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string ACTION URL to go after
   * @parameter string METHOD  "post" or "get"
   */
  function __construct($attrs = array()) 
    {
      parent::__construct($attrs);
    }

  function preChilds() 
    {  
      $this->HTMLfields=array('ACTION','METHOD');
    }
}
// }}}
?>