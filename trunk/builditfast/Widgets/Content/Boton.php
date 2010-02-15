<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file hold class Boton
 * @package BIF3
 */

// {{{ class Boton
/**
 * Boton is ment to be user with 'Botonera'
 *
 * Boton is Button in spanish, is a button-like widget for
 * decoration/design propouse. I'm not using it in any of my 
 * projects right now, just preservig for backward compatibility.
 *
 * @package  BIF3
 * @subpackage Widgets/Content
 * @author   Nicolas D. Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.5.26.3 $
 */

class Boton extends BifWidget 
{
/** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the 
following keys: (in CAPS!)
   * @parameter string TEXT Link's text.
   * @parameter string HREF Link's URL.
   * @parameter string TARGET Link's target.
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);
  } // }}}
  
  function innerDraw() {
    $this->RAWfields=array("TEXT");
    $this->HTMLfields=array("HREF","TARGET");
  }
} // }}}
?>