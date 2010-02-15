<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class Title3
 * @package  BIF3
 */
// {{{ class Title3
/**
 * Use Title widget for titles. Just a design tool.
 *
 * Title is used for design propouse.
 * There are different Title for design propuse, usually equivalent
 * to html's H1 H2 H3 tags.
 * 
 * @package  BIF3
 * @subpackage Widgets/Text
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.4.26.3 $
 */

class Title3 extends BifWidget 
{
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string TEXT Title's text
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);
  }

  function innerDraw() {
    if($this->attributes['TEXT']) {
      $this->tpl->setVariable('TEXT', $this->attributes['TEXT']);
    } else {
      $this->tpl->setVariable('TEXT', '&nbsp;');
    }
  }
}
?>