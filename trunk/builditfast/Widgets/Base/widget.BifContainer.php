<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 
/**
 * This file holds class BifContainer
 * @package BIF3
 */

/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/Base/widget.BifWidget.php");
// {{{ class BifContainer
/**
 * The simplest container, mother of all other containers
 *
 * All containers in BIF3 should extend BifContainer, so
 * no code repetition is made.
 *
 * @package  BIF3
 * @subpackage Widgets/Base
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.16.6.3 $
 * @see BifWidget
 */
class BifContainer extends BifWidget{
  var $positions = array();
  
  function __construct($attrs = array())
  {
    parent::__construct($attrs);
    $this->addPosition('CHILD');
  }

  function addPosition($position)
  {
	$this->positions[$position]=array();
  }

  function addChild(&$myChild,$at = 'CHILD')
  {
    if (!isset($this->positions[$at]) ){
		$this->addPosition($at);
//		echo  $at . "<br>";
	}
	$this->positions[$at][] = &$myChild;
  }

  function &getWidget($name) 
  {
    if ($this->attributes['BIFID']==$name) {
      return($this);
    }
    $keys = array_keys($this->positions);
    $size = sizeOf($keys);
    // for each position
    for ($i=0; $i<$size; $i++) {
      $pos=&$this->positions[$keys[$i]];
      $posindex=sizeOf($pos);
      // for each children in the position
      for($c=0;$c < $posindex;$c++) {
	$ret=& $pos[$c]->getWidget($name);
	if($ret != FALSE) {
	  return($ret);
	}
      }
    }
    return($a=FALSE);
  }
  
  function innerDraw() 
  {
    $this->preChilds();
    $keys = array_keys($this->positions);
    $size = sizeOf($keys);

    // for each position
    for ($i=0; $i < $size; $i++) {
      $theKey=$keys[$i];
      $pos=&$this->positions[$theKey];
      $posindex=sizeOf($pos);

      // for each children in the position
      for($c=0;$c < $posindex;$c++) {
	$this->tpl->setVariable($theKey , $pos[$c]->draw());
	$this->tpl->parse($theKey);
      }
    }
    $this->postChilds();
  }
  // Dummy functions may be implemented in childs.
  function preChilds() {}  //actions to take _before_ parsing all childs 
  function postChilds() {} //actions to take _after_  parsing all childs 
}
// }}}
?>
