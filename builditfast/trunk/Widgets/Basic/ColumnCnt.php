<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class ColumnCnt
 * @package  BIF3
 */
// {{{ class ColumnCnt
/**
 * A vertical container, it makes a new row for each child
 *
 * @package  BIF3
 * @subpackage Widgets/Basic
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.7.26.3 $
 */
class ColumnCnt extends BifContainer {
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string WIDTH Width of table 
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);
  }

  function preChilds() {  //actions to take _before_ parsing all childs 
    $this->HTMLfields=array("WIDTH");
  }
}
// }}}
?>