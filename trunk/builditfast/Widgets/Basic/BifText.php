<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class BifText
 * @package  BIF3
 */
// {{{ class BifText
/**
 * Basic widget to include text
 *
 * @package  BIF3
 * @subpackage Widgets/Basic
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.9.26.3 $
*/

class BifText extends BifWidget 
{
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string TEXT Text to be displayed
   * @parameter string COLOR Color of  text
   * @parameter string SIZE Size of text
   */
  function __construct($attrs = array()) 
    {
      parent::__construct($attrs);
    }

  function innerDraw() 
    { 
      $this->HTMLfields=array("COLOR","SIZE");
      if ($this->attributes["TEXT"])
	$this->tpl->setVariable("TEXT", $this->attributes["TEXT"]);
      else 
	$this->tpl->setVariable("TEXT", "&nbsp;");
    }
}
// }}}
?>