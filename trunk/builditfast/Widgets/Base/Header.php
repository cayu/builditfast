<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 
/**
 * This file holds class Header
 * @package BIF3
 */

/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/Base/widget.BifWidget.php");
// {{{ class Header
/**
 * The pages' header
 *
 * Usually 'My Site' logo is in all pages,
 * this widget is a header for that work
 *
 * @package  BIF3
 * @subpackage Widgets/Base
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.6.2.3 $
 * @see BifRoot3
 */
class Header extends BifWidget {
  function __construct($attrs = array())
  {
    parent::__construct($attrs);
  }
}
// }}}
?>
