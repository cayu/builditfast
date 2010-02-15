<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 
/**
 * This file holds class BifRoot2
 * @package BIF3
 */

/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/Base/widget.BifRoot.php");
// {{{ class BifRoot2
/**
 * The main container for all pages
 *
 * BifRoot is an special widget that uses
 * &lt;HTML&gt;&lt;/HTML&gt; to include all
 * other widgets
 *
 * This Class is an alterantive to BifRoot depending on
 * the application design needs 
 *
 * @package  BIF3
 * @subpackage Widgets/Base
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.5.6.3 $
 * @see BifRoot
 */
class BifRoot2 extends BifRoot {
  function __construct($attrs = array())
  {
    parent::__construct($attrs);
  }
}
?>
