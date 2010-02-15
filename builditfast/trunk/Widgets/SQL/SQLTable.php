<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 
/**
 * This file hold class SQLTable
 * @package BIF3
 */

// {{{ class SQLTable
/**
 *
 * A simple table based on SQL query. 
 * 
 * It can use either a parameter QUERY or set a result using
 * setResult($result) method.
 *
 * @package  BIF3
 * @subpackage Widgets/SQL
 * @author   Nicolas D. Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.1.2.1 $
 */

class SQLTable extends BifWidget {
  /* var: result
   * a PEAR's DBResult object, use in case you already made the execQuery()
   */
  var $result;

  /* var: render
   * a Render object for the table
   */
  var $render;


  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string QUERY SQL query to show
   * @parameter string EMPTY a string to be used in case is an empty result. (else is 'Ningún resultado' is used)
   * @parameter string HIDDEN coma separated values of hidden rows 
   * @parameter string NOHEADER if has any value, supress automatic header
   * @parameter string RENDER a render class name
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);
  } // }}}

  function setResult(&$result) {
    $this->result =& $result;
  }

  function innerDraw() {

  if (!isset($this->attributes['EMPTY']))
    $this->attributes['EMPTY'] = 'Ningún resultado';

    if ($query =  $this->attributes['QUERY']) {
      $this->result =&  $_SESSION['_BifApplication']->execQuery($query);
      if (DB::isError($this->result) ) {
	$this->warning =  &new BifWarning(array('TEXT' => $this->result->getMessage()));
      }
    }

    if (!isset($this->result)) {
      $this->warning =  &new BifWarning(array('TEXT' => 'No result set in line '.__LINE__.' at '.__FILE__));
      return;
    }

    if (DB::isError($this->result)) {
	die ($this->result->getMessage());
    }
    $info = $this->result->tableinfo();

    if (DB::isError($info)) {
      die ($info->getMessage());
    }

  if ($this->attributes['HIDDEN'])
      $hidden=explode(',',$this->attributes['HIDDEN']);
    else
      $hidden=array();

  if ($this->attributes['NOHEADER']) {
    $this->tpl->setVariable('HEADROW','');
  } else {
    foreach ($info as $HeadInfo) {
      if (!in_array($HeadInfo['name'],$hidden)) {
	$this->tpl->setVariable('TH',$HeadInfo['name']);
	$this->tpl->parse('HEAD');
      }
    }
    $this->tpl->parse('HEADROW');
  }

  if ($this->attributes['RENDER']) {
    $this->addRender($this->attributes['RENDER']);
  }


  if ($this->result->numRows() == 0) {
    $columnas = $this->result->numCols() - sizeof($hidden);
    $this->tpl->setVariable('EXTRA',' colspan="'. $columnas .'" ');
    $this->tpl->setVariable('DATA',$this->attributes['EMPTY']);
    $this->tpl->parse('ROW');
  } else {
    while ($row = $this->result->fetchRow(DB_FETCHMODE_ASSOC)) {
      foreach ($row as $key => $data) {
	if (!in_array($key,$hidden)) {
	  if (isset($this->render)) {
	    $this->tpl->setVariable('DATA',$this->render->renderMySQLCell($row,$key));
	  } else {
	    $this->tpl->setVariable('DATA',$data);
	  } 
	  $this->tpl->parse('CELL');
	}
      }
    $this->tpl->parse('ROW');
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