<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds class MenuText
 * @package  BIF3
 */
// {{{ class MenuText
/**
 * Menu drop down con CSS sin JavaScript
 *
 * 
 * @package  BIF3
 * @subpackage Widgets/Text
 * @author   Sergio Cayuqueo <linuxvarela@yahoo.com.ar>
 * @version  $Revision: 1.1.2.2 $
 */

class MenuText extends BifWidget {

  function __construct($attrs = array()) {
    parent::__construct($attrs);
  }

  function innerDraw() {
    $this->RAWfields=array("HREF","TEXT");
  }

}

?>