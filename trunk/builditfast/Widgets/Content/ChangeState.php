<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file hold class ChangeState
 * @package BIF3
 */

// {{{ class ChangeState
/**
 * Abstract class. Implement childs with 2 representations URL based
 *
 * Usually, we want to show -for example- highlighted buttons to show
 * an special part of our bif application. It uses 2 diferent tpl for
 * this propouse: 'widgetname.tpl' and 'widgetname-selected.tpl'
 * 
 * Example:
 *
 * The REGEXP parameter could be '.*script\.php.*' and the name of the
 * child class could be MeButtone
 *
 * then, MeButtone will change it's representation at script.php and
 * in the rest of the site will remain with default behaviour
 * 
 * @package  BIF3
 * @subpackage Widgets/Content
 * @author   Nicolas D. Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.9.6.3 $
 */

class ChangeState extends BifWidget 
{
/** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the 
following keys: (in CAPS!)
   * @parameter string REGEXP Regular expresion to match script name to determinate if it should be selected.
   */
  function __construct($attrs = array()) {
    if (ereg($attrs["REGEXP"], basename($_SERVER["SCRIPT_NAME"]))) { // then it's selected
      $this->widgetName = get_class($this) . "-selected";
    }
    parent::__construct($attrs);
  } // }}}
} // }}}
?>