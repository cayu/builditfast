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
 * Table row container, includes BifTableDataCnt
 *
 * This container is for Tables generation, children should only be  
 *  BifTableDataCnt 
 * Note: now we can use the
 * <tr></tr> tag in most cases, (a is an HTMLTag widget)
 *
 * @package  BIF3
 * @subpackage Widgets/Basic
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.7.26.3 $
 */
class BifTableRowCnt extends BifContainer 
{
  /** {{{ function Constructor
   * @parameter $attrs No attributes suported right now, only it's parent: BifContainer
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);
  }
}
// }}}
?>