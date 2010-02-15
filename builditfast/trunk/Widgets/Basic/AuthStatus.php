<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class AuthStatus
 * @package  BIF3
 */
// {{{ class AuthStatus
/**
 * Shows user authentication status (logged, logging, anonymous, etc)
 *
 * @package  BIF3
 * @subpackage Widgets/Basic
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.3.2.3 $
*/

class AuthStatus extends BifWidget 
{
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   */
  function __construct($attrs = array()) 
    {
      parent::__construct($attrs);
    }

  function draw()
    {
      if ($this->hasAccess()) {
	  global $app_dir;
	$this->tpl =& new HTML_Template_Sigma('',$app_dir."/cache/tpl/");
	if ($tmp= $_SESSION['_BifApplication']->skin($this->widgetName, "_template")) {
	  $this->tpl->loadTemplatefile($tmp) ;
	} else {
	  die("I don't have template file for $this->widgetName");
	}

	$this->attributes['LEVEL']  =  $_SESSION['_BifApplication']->getVar('user_level')    ;
	$this->attributes['USER']   =  $_SESSION['_BifApplication']->getVar('user_username') ;
	$this->attributes['STATUS'] =  $_SESSION['_BifApplication']->getVar('user_auth');
	$this->attributes['KEYS']   =  $_SESSION['_BifApplication']->getVar('user_keys');
      
	$this->RAWfields=array("STATUS","USER","LEVEL","KEYS");
	$this->parseStructures();
	if ($this->attributes['STATUS'] == 'logged') {
	  $this->tpl->parse('LOGGEDBLOCK');
	} else {
	  $this->tpl->parse('NOTLOGGEDBLOCK');
	}
	return $this->tpl->get();
      }
    }
}
// }}}
?>
