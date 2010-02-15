<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class BifLink
 * @package  BIF3
 */
// {{{ class BifLink
/**
 * Implements a Basic Link for multiple usage
 *
 * This is the inital class used for links, now we can use the
 * <a href=""></a> tag in most cases, (a is an HTMLTag widget)
 *
 * @package  BIF3
 * @subpackage Widgets/Basic
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.9.26.3 $
 */
 
class BifLink extends BifWidget 
{
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string TEXT Link's text.
   * @parameter string HREF Link's URL.
   * @parameter string TARGET Link's target.
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);
  }
  
  function innerDraw() {
    $this->RAWfields=array("TEXT");
    $this->HTMLfields=array("HREF","TARGET");
  }
}
// }}}
?>
