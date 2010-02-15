<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class BifRawText
 * @package  BIF3
 */
// {{{ class BifRawText
/**
 * Basic widget to include text in 'raw mode'
 *
 * Note: text included by render() uses this widget
 * 
 * @package  BIF3
 * @subpackage Widgets/Basic
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.8.2.3 $
 */
class BifRawText extends BifWidget {
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string TEXT Text to be displayed
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);
  }

  function draw() {
      return $this->attributes['TEXT'];
  }
}
// }}}
?>
