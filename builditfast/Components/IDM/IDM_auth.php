<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 
 
global $sys_dir;
require_once("$sys_dir/Components/IDM/IDM.php");
class IDM_auth extends IDM {

  function __construct($id,$params = array()) {
    parent::__construct($id, $params);
  }

  function publicInit() {
    $this->table               = 'auth';
    $this->primaryKey          = array('username');
    $this->importantFields     = array('username');
    $this->searchField         = 'username';
    $this->active              = 'habilitado';
    $this->SQLRender           = 'Render_auth';
    $this->update              = array();
    $this->fields = array(
			  array('username',"varchar(250) NOT NULL default ''",
				'FTText','',
				'check_alfanum','',true),

			  array('password',"varchar(250) NOT NULL default ''",
				'FTPassword','',
				'check_alfanum','md5',true),

			  array('keys',"varchar(250) NOT NULL default ''",
				'FTText','',
				'','',true),

			  array('level',"int(6)  NOT NULL  default '10'",
				'FTText','',
				'check_num','',true),

			  //			  array('habilitado',"tinyint(1) NOT NULL default '1'",
			  );
    parent::publicInit();
  }

}

class Render_auth {
  var $logicalID  = 'm_auth';

  function Render_auth() {
  }

  function renderMySQLCell($fila,$key) {
    switch ($key) {
    case 'Borrar':
      return "<a href=\"?action=$this->logicalID.Delete&amp;".
	"username=" . $fila["username"] . "\">Borrar</a> ";
      break;
    case 'Modificar':
      return "<a href=\"?action=$this->logicalID.ModifyView&amp;".
	"username=" . $fila["username"] . "\">Modificar</a> ";
      break;
    default:
      return $fila[$key];
    }
  }
}
?>
