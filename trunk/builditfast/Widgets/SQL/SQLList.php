<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file hold class SQLList
 * @package BIF3
 */

// {{{ class SQLList
/**
 * This an abstract widget to display lists.
 *
 * The field name will be used in template file.
 * 
 * is as simple as this:
 * 
 * <pre>
 * class List extens SQLList {
 *   function __construct($attrs = array()) {
 *     $attrs['QUERY'] = "select nombre from padron";
 *     parent::__construct($attrs);
 *   }
 * }
 * </pre>
 * 
 * and mylist.tpl 
 * <pre>
 * ---------------------------
 * &lt;!-- BEGIN item --&gt;
 * {nombre}&lt;br&gt;
 * &lt;!-- END item --&gt;
 * ---------------------------
 * </pre>
 *
 * @package  BIF3
 * @subpackage Widgets/SQL
 * @author   Nicolas D. Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.1.2.1 $
 */

class SQLList extends BifWidget {

  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string QUERY a SQL query
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);
  } // }}}

  function innerDraw() {
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
    
    while ($row = $this->result->fetchRow(DB_FETCHMODE_ASSOC)) {    
      $keys = array_keys($row);      
      foreach ($keys as $key) { 
	$this->tpl->setVariable($key,$row[$key]);
      }
      $this->parseRow($row);
      $this->tpl->parse('item');
    }
  }
  // Abstract function
  function parseRow($row){

  }

} // }}}
?>