<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file hold class SQLSelect
 * @package BIF3
 */

// {{{ class SQLSelect
/**
 * An html's "select" input generated from a MySQL Query
 *
 * NOTE:It can use a parameter QUERY or set a result using
 * setResult($result) method.
 *
 *
 * @package  BIF3
 * @subpackage Widgets/SQL
 * @author   Nicolas D. Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.1.2.1 $
 */

class SQLSelect extends BifWidget {
  /* var: result
   * a PEAR's DBResult object, use in case you already made the execQuery()
   */
  var $result;

  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string QUERY MySQL query to show
   * @parameter string NAME input Name
   * @parameter string EXTRA coma-separated values of extra entries
   * @parameter string VALUE a value to 'select' an entry
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);
  } // }}}

  function setResult(&$result) {
    $this->result =& $result;
  }

  function innerDraw() {
    if ($query =  $this->attributes["QUERY"]) {
      $this->result =& $_SESSION['_BifApplication']->execQuery($query);
    }

    if (!isset($this->result)) {
      $this->warning =  new BifWarning(array('TEXT' => 'MySQL widget needs result or query to display'));
      return;
    }

    if ($this->attributes['NAME'] == '') {
      $this->warning =  new BifWarning(array('TEXT' => 'No NAME attribute assigned to MySQLSelect '));
      return;
    }

    $this->tpl->setVariable('NAME',$this->attributes['NAME']);
    
    $extra =  $this->attributes["EXTRA"];
    if ($extra) {
      $keyvals = explode(';',$extra);
      foreach ($keyvals as $keyval) {
	list($key,$val) = explode(',',$keyval);
	$this->tpl->setVariable('VALUE',$val);
	$this->tpl->setVariable('TEXT',$key);
	if ($this->attributes['VALUE'] == $val) {
	  $this->tpl->setVariable('SELECTED','selected');
	}else{
	  $this->tpl->setVariable('SELECTED','');
	}
	$this->tpl->parse("ROW");
      }
    }
    
    while ($row = $this->result->fetchRow(DB_FETCHMODE_ORDERED)) {
      $val = array_shift($row);
      $this->tpl->setVariable('VALUE',$val);
      $this->tpl->setVariable('TEXT',implode(' ',$row));
      if ($this->attributes["VALUE"] == $val) {
	$this->tpl->setVariable('SELECTED','selected');
      }else{
	$this->tpl->setVariable('SELECTED','');
      }
      $this->tpl->parse("ROW");
    }
  }
} // }}}
?>