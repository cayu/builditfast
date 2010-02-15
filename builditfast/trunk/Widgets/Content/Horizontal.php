<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds the Horizontal class
 * @package BIF3
 */

// {{{ class Horizontal
/**
 * An horizontal container, it's meant to be used with Boton widgets!
 *
 * @package    BIF3
 * @subpackage Widgets/Content
 * @author     Nicolás D. César <ncesar@lunix.com.ar>
 * @version    $Revision: 1.4.26.3 $
 */
class Horizontal extends BifContainer {
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash in CAPS.
   * @parameter string WIDTH Horizontal's width in pixels or screen percent.
   * @parameter string BGCOLOR Color used on Horizontal's background, using the format #AABBCC (RGB)
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);
  } // }}}

  function preChilds() {
    $this->HTMLfields = array('WIDTH','BGCOLOR');
   
  }

} // }}}

?>