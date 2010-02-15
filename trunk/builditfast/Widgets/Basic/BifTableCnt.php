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
 * Table container, includes BifTableRowCnt and  BifTableDataCnt
 *
 * This container is for Tables generation, children should be  
 * BifTableRowCnt and  BifTableDataCnt 
 * Note: now we can use the
 * <table></table> tag in most cases, (a is an HTMLTag widget)
 *
 * @package  BIF3
 * @subpackage Widgets/Basic
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.9.26.3 $
*/
class BifTableCnt extends BifContainer {
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string WIDTH Table width
   * @parameter string ALIGN Table align
   * @parameter string CELLPADDING Cell padding
   * @parameter string CELLSPACING Cell spacing
   * @parameter string BORDER Border
   */
  function __construct($attrs = array()) 
    {
      parent::__construct($attrs);
    }

  function preChilds()
    {
      $this->HTMLfields = array('WIDTH','ALIGN','CELLPADDING','CELLSPACING','BORDER');
    }
}
// }}}
?>