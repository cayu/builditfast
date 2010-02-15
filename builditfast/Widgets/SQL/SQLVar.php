<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */

/**
 * This file hold class SQLVar
 * @package BIF3
 */

// {{{ class SQLVar
/**
 * It's a useful widget as a variable replacement for .bif
 * @package  BIF3
 * @subpackage Widgets/SQL
 * @author   Sergio Cayuqueo <linuxvarela@yahoo.com.ar>
 * @version  $Revision: 1.1.2.1 $
 */
class SQLVar extends BifWidget {

  var $table = "variables";
  var $keyField = "key";
  var $valueField = "value";
  var $habilitadoField = "habilitado";

  // {{{ function Constructor
  /** 
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string NAME variable's name 
   * @parameter string TABLE table that holds key => value (default: 'variables')
   * @parameter string KEYFIELD key's field's name (default: 'key')
   * @parameter string VALUEFIELD value's field's name (default: 'value')
   * @parameter string HABILITADOFIELD boolean'enable' field (default: 'habilitado')
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);
  } // }}}

  function innerDraw() {
    if (!$this->attributes['NAME']) {
      $this->warning =& new BifWarning(array("TEXT"=>"missing NAME attribute"));
      return;
    } else {
      $this->name = $this->attributes['NAME'];
    }

    if ($this->attributes['TABLE']) {
      $this->table = $this->attributes['TABLE'];
    }
    if ($this->attributes['KEYFIELD']) {
      $this->keyField = $this->attributes['KEYFIELD'];
    }
    if ($this->attributes['VALUEFIELD']) {
      $this->valueField = $this->attributes['VALUEFIELD'];
    }
    if ($this->attributes['HABILITADOFIELD']) {
      $this->habilitadoField = $this->attributes['HABILITADOFIELD'];
    }
//--- SQL
    $sql =
"SELECT
    $this->valueField
 FROM
    $this->table
 WHERE
    `$this->keyField` = '$this->name' AND
    `$this->habilitadoField` = '1' ";
//---
    $result = $_SESSION['_BifApplication']->execQuery($sql);
    if ($result->numRows() == 0) {
      $this->warning =& 
	new BifWarning(array("TEXT"=>
			     "No key '$this->name' at table '$this->table'"));
    }
    $row = $result->fetchRow();
    $this->tpl->setVariable($this->valueField,$row[0]);
  }
} // }}}
?>
