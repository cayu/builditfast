<?php 
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

global $sys_dir;
require_once("$sys_dir/Components/IDM/IDM.php");

// {{{ class IDM_links
/**
 * Insert, Delete and Modify links
 * 
 * Uses 'links' table to store links' url,
 * description and text.
 *
 * @package  BIF3
 * @subpackage Components/IDM.php
 * @author Sergio Cayuqueo <linuxvarela@yahoo.com.ar>
 */
class IDM_links extends IDM {

  function __construct($id, $params = array()) {
    parent::__construct($id, $params);
  }
  
  function publicInit() {
    $this->table = 'links';
    $this->primaryKey = array('id');
    $this->importantFields = array('id','nombre','url','descripcion');
    $this->searchField = 'nombre';
    $this->active = 'habilitado';
    $this->SQLRender = 'Render_links';
    $this->update = array('Updatelinks');
    $this->fields = array(
			  array('id',"int(11) NOT NULL auto_increment",
				'FTShow','','','',true),
			  array('nombre',"varchar(100) NOT NULL default ''",
				'FTText','size="40"','check_alfanum','',true),
			  array('url',"varchar(100) NOT NULL default ''",
				'FTText','size="60"','','',true),
			  array('descripcion',"Mediumtext",
				'FTTextarea','rows="10" cols="40"','check_alfanum','',true),
			  );
    parent::publicInit();
  }
}

class Render_links {
  var $logicalID  = 'm_links';

  function Render_links() {
  }

  function renderMySQLCell($fila,$key) {
    switch ($key) {
      
    case 'Borrar':
      return "<a href=\"?action=$this->logicalID.Delete&amp;".
	"id=".$fila["id"]."\">Borrar</a> ";
      break;
    case 'Modificar':
      return "<a href=\"?action=$this->logicalID.ModifyView&amp;".
	"id=".$fila["id"]."\">Modificar</a> ";
      break;
    default:
      return $fila[$key];
    }
  }
}
// }}}
?>
