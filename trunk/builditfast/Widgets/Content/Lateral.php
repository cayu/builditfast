<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds the Lateral class
 * @package BIF3
 */

// {{{ class Lateral
/**
 * A vertical container, it's meant to be used with Boton widgetsi!
 *
 * @package    BIF3
 * @subpackage Widgets/Content
 * @author     Nicolás D. César <ncesar@lunix.com.ar>
 * @version    $Revision: 1.5.26.3 $
 */
class Lateral extends BifContainer {
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash in CAPS.
   * @parameter string WIDTH Lateral's width in pixels or screen percent
   * @parameter string BGCOLOR Color used on Lateral's background, using the format #AABBCC (RGB)
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);
  } // }}}

  function preChilds() {
    $this->HTMLfields = array('WIDTH','BGCOLOR');
   
  }

} // }}}

?>