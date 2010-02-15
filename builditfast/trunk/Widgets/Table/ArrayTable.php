<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds class Application
 * @package BIF3
 */

// {{{ class ArrayTable
/**
 * A simple table based on an Array
 *
 * It can use a parameter QUERY or set a result using
 * setResult($result) method.
 *
 * @package    BIF3
 * @subpackage Widgets/Table
 * @author     Nicolas Cesar <ncesar@lunix.com.ar>
 * @version    $Revision: 1.5.26.3 $
 */
class ArrayTable extends BifWidget {
  var $result;
  var $render;
  // {{{ function ArrayTable
  /**
   * @parameter $attr 
   * @parameter string COLS Number of columns
   * @parameter string DATA values separated by commas. First COLS items will be the headings.
   * @parameter string RENDER SQL render class name. (see Tutorial)
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);
  } // }}}

  function setResult(&$result) {
    $this->result =& $result;
  }

  function innerDraw() {

    if ($this->attributes['RENDER']) {
      $this->addRender($this->attributes['RENDER']);
    }

    $matriz = explode(',', $this->attributes['DATA']);
    $head = true;
    $c = 0;
    foreach($matriz as $valor) {
      if (isset($this->render)) {
	$this->tpl->setVariable('DATA',$this->render->renderArrayCell($valor,$a,$c));
      } else {
	$this->tpl->setVariable('DATA',$valor);
      }
      $this->tpl->parse('CELL');
      $a++;
      if(($a = $a % $this->attributes['COLS']) == 0) {
	$this->tpl->parse('ROW');
	$c++;
      }
    }
  }
  
  function addRender($class) {
    if (class_exists($class)) {
      $this->render= new $class();
    } else {
      die("Can't instace class $class<br>");
    }
  }
} // }}}

?>