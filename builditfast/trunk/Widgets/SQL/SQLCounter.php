<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file hold class SQLCounter
 * @package BIF3
 */

// {{{ class SQLCounter
/**
 * Rustic Visit counter... 
 * 
 * @package  BIF3
 * @subpackage Widgets/SQL
 * @author   Sergio Cayuqueo <linuxvarela@yahoo.com.ar>
 * @version  $Revision: 1.1.2.1 $
 */

class SQLCounter extends BifWidget {

  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string NAME counter name (default: 'default')
   * @parameter string TABLE table name (default: 'mycounter')
   */
  function __construct($param = array()) {
    $this->BifWidget($param);
  }

  function innerDraw() {
    //Chequear el nombre de la pagina para registrarlo en el contador
    if(!$this->attributes['NAME']) {
      $this->attributes['NAME'] = "default"; 
    }

    if (! $this->attributes['TABLE']) {
      $this->attributes['TABLE'] = 'mycounter';
    }

    //Consulta del conteo 
    $result =   $_SESSION['_BifApplication']->execQuery("SELECT name,count FROM ". 
							$this->attributes['TABLE'] .
							" WHERE name='". 
							$this->attributes['NAME']. "'");
    $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
    $count = $row['count'];

    //Conteo inicial, si es la primera vez que se ejecuta el contador
    if(!$count) {
      $_SESSION['_BifApplication']->execQuery("INSERT INTO ". $this->attributes['TABLE'] . " VALUES ('" . $this->attributes['NAME'] ."','1')");
      $count = "1";
    }

    $l = strlen($count)-1;
    for($i=0;$i<=$l;$i++)
      {
	$this->tpl->setVariable('NUMBER',$count[$i]);
	$this->tpl->parse('ITEM');
      }
    $_SESSION['_BifApplication']->execQuery("UPDATE ".$this->attributes['TABLE']. " set count=count+1 WHERE name=\"".$this->attributes['NAME']."\"");
  } // }} 
} // }}}
?>