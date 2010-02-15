<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds class BifLangSelector
 * @package  BIF3
 */
// {{{ class BifLangSelector
/**
 * Language Selector
 *
 * @package  BIF3
 * @subpackage Widgets/Basic
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.1.14.3 $
*/

class BifLangSelector extends BifWidget 
{
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)

   */
  function __construct($attrs = array()) 
    {
      parent::__construct($attrs);
    }
  function innerDraw() 
    {
      global $bifcfg;
      $cfg = $bifcfg['i18n'];
      $supported = $cfg['supported'];
      $actual = $_SESSION['_BifApplication']->getVar('lang');
      foreach ($supported as $lang_name => $value) {
	if ($value == $actual) {
	  $this->tpl->setVariable('SELECTED','selected');
	  $this->tpl->setVariable('LANG',$lang_name.' (*)');
	} else {
	  $this->tpl->setVariable('LANG',$lang_name);
	  $this->tpl->setVariable('SELECTED','');
	}
	  $this->tpl->setVariable('VALUE',$value);
	$this->tpl->parse('OPTIONS');
      }

    }

}
// }}}
?>