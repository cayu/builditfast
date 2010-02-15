<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 
/**
 * This file holds class BifRoot
 * @package BIF3
 */

/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/Base/widget.BifContainer.php");

$headSlotStr = array();
function addHeadSlot($str) {
  global $headSlotStr;

  $headSlotStr[$str] = "1";
}

$bodyOptStr = "";
function addBodyOpt($str) {
  global $bodyOptStr;

  $bodyOptStr .= $str . "\n";
}

$preloadImages = array();
function addPreloadImage($str) {
  global $preloadImages;

  $preloadImages[$str] = "1";
}

// {{{ class BifRoot
/**
 * The main container for all pages
 *
 * BifRoot is an special widget that uses
 * &lt;HTML&gt;&lt;/HTML&gt; to include all
 * other widgets
 *
 * @package  BIF3
 * @subpackage Widgets/Base
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.12.6.3 $
 */
class BifRoot extends BifContainer {

  var $array_preload = array();
  var $array_css = array();

  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string TITLE Page's title
   */
  function __construct($attrs = array())
  {
    parent::__construct($attrs);
  }

function innerDraw()
  {
    global $headSlotStr;
    global $bodyOptStr;
    global $preloadImages;
    $this->RAWfields=array("TITLE");
    parent::innerDraw();
    //----------------
    // if some called function addHeadSlot() then we print it
    if ($headSlotStr) {
      $this->tpl->setVariable("HEAD_SLOT",implode("\n",array_keys($headSlotStr)));
    } else {
      $this->tpl->setVariable("HEAD_SLOT","");
    }   
    // if some called function addBodyOpt() then we print it
    if ($bodyOptStr) {
      $this->tpl->setVariable("BODY_OPT",$bodyOptStr);
    } else {
      $this->tpl->setVariable("BODY_OPT","");
    }   
    // if some called function addPreloadImage() then we print it
    if ($preloadImages) {
      $this->tpl->setVariable('PRELOAD',
	'onLoad="MM_preloadImages(\''. 
        implode("','",array_keys($preloadImages)) .
        '\')"' );
    } else {
      $this->tpl->setVariable("PRELOAD","");
    }  
 }
} // }}}
?>
