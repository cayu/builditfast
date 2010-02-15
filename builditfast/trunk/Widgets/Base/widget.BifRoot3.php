<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 
/**
 * This file holds class BifRoot3
 * @package BIF3
 */

/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/Base/widget.BifRoot.php");
require_once("$sys_dir/Widgets/Base/Header.php");
require_once("$sys_dir/Widgets/Base/Footer.php");

// {{{ class BifRoot3
/**
 * The main container for all pages
 *
 * BifRoot is an special widget that uses
 * &lt;HTML&gt;&lt;/HTML&gt; to include all
 * other widgets
 *
 * This Class is an alterantive to BifRoot depending on
 * the application design needs, it holds a header widget
 * and a footer widget
 *
 * @package  BIF3
 * @subpackage Widgets/Base
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.6.6.3 $
 * @see BifRoot Header Footer
 */
class BifRoot3 extends BifRoot {
  function __construct($attrs = array())
  {
    parent::__construct($attrs);
  }

  function preChilds() {
    $f =& new Footer;
    $h =& new Header;
    $this->tpl->setVariable("FOOTER",$f->draw());
    $this->tpl->setVariable("HEADER",$h->draw());
  }
}
?>
