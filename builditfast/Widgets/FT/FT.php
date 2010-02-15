<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds the FT class
 * @package BIF3
 */

// {{{ class FT
/**
 * Main container of FT items (widgets)
 *
 * FT stands for Form-Table. It's a Form containing a three-column table
 * that's meant to be used on forms for user input.
 *
 * @package    BIF3
 * @subpackage Widgets/FT
 * @author     Nicolás D. César <ncesar@lunix.com.ar>
 * @version    $Revision: 1.7.2.3 $
 */
class FT extends BifContainer {
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash in CAPS.
   * @parameter string ACTION The URL to be called (generally a script) with the data added to the form.
   * @parameter string METHOD Can be GET or POST.
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);
    $this->HTMLfields=array('ACTION','METHOD');
  } // }}}
} // }}}

?>