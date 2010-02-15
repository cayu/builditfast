<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class BifTableCnt
 * @package  BIF3
 */
// {{{ class BifTableCnt
/**
 * Table Data Cell container
 *
 * This container is for Tables generation.
 * Note: now we can use the
 * <td></d> tag in most cases, (a is an HTMLTag widget)
 *
 * @package  BIF3
 * @subpackage Widgets/Basic
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.10.26.3 $
 * @see BifTableRowCnt BifTableCnt 
 */
class BifTableDataCnt extends BifContainer 
{
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string COLSPAN column span
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);
  }

  function preChilds() {
    $this->HTMLfields=array('COLSPAN');
  }
}
// }}}
?>