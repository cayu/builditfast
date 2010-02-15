<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 
/**
 * This file holds class BifWarning
 * @package BIF3
 */

/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/Base/widget.BifWidget.php");
// {{{ class BifContainer
/**
 * Special widget designed to show errors in widgets
 *
 * Each BifWidget has an attribure 'warning' it's used to
 * represent errors. A BifWarning is used to generally 
 * show the errors, could implement specific site bug
 * reports, for example.
 *
 * @package  BIF3
 * @subpackage Widgets/Base
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.9.6.3 $
 * @see BifWidget
 */
class BifWarning extends BifWidget {
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string TEXT The warning message.
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);
  }
  function innerDraw() {
    $this->RAWfields=array('TEXT');
  }
}
?>
