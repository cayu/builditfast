<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file hold class Draft
 * @package BIF3
 */

// {{{ class Draft
/**
 * A 'draft' widget, useful tool when making an application
 *
 * When you need to express an idea, you can fill with draft widgets
 * saying 'here will go the product list' and 'here will be links list'
 * 
 * So you can preview an application's  prototype.
 *
 * @package  BIF3
 * @subpackage Widgets/Content
 * @author   Nicolas D. Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.3.26.3 $
 */

class Draft extends BifContainer {

/** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the 
following keys: (in CAPS!)
   * @parameter string WIDTH table's fixed width
   * @parameter string ALIGN table's align
   * @parameter string CELLPADDING Cell padding
   * @parameter string CELLSPACING Cell spacing
   * @parameter string BORDER border
   * @parameter string BGCOLOR background collor
   */
  function __construct($attrs = array()) 
    {
      parent::__construct($attrs);
    }// }}}
  
  function preChilds() 
    {
      $this->HTMLfields = array('WIDTH','ALIGN','CELLPADDING','CELLSPACING','BORDER','BGCOLOR');
    }
}// }}}
?>