<?php 

/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Gleducar - WEB
 * Gleducar - WEB is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds class IDM_Areasnoticias
 * @package  BIF3
 */

/**
 * Required files
  */
  global $sys_dir;
  require_once("$sys_dir/Components/IDM/IDM.php");


// {{{ class IDM_Areasnoticias
/**
 * A IDM (insert Delete Modify, for table areasnoticias
 *
 * @package  BIF3
 * @subpackage Components
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.1.2.1 $
 */

class IDM_areasnoticias extends IDM {

  function __construct($id,$params = array()) {
    parent::__construct($id, $params);
  }

  function stubUpdateEscuela() {
    $this->publicInit();
  }

  function publicInit() {

    /* Debería hacer "
ALTER TABLE `area` ADD UNIQUE (
 `Area` 
) "
*/
    $this->table               = 'areasnoticias';
    $this->primaryKey          = array('id');
    $this->importantFields     = array('id','Area');
    $this->searchField         = 'Area';
    $this->active              = 'habilitado';
    $this->SQLRender           = 'Render_areasnoticias';
    $this->update              = array('UpdateArea');
    $this->fields = array(
			  array('id','int(11) NOT NULL auto_increment','FTShow','','','',true),
			  array('Area',"varchar(150) NOT NULL default ''",'FTText','','check_alfanum','',true),
			  );
    parent::publicInit();
  }
}

class Render_areasnoticias {
  var $logicalID  = 'm_areasnoticias';

  function RenderAreasnoticias() {
  }

  function renderMySQLCell($fila,$key) {
    switch ($key) {
    case 'Borrar':
      return "<a href=\"?action=$this->logicalID.Delete&amp;".
	"id=" . $fila["id"] . "\">Borrar</a> ";
      break;
    case 'Modificar':
      return "<a href=\"?action=$this->logicalID.ModifyView&amp;".
	"id=" . $fila["id"] . "\">Modificar</a> ";
      break;
    default:
      return $fila[$key];
    }
  }
}
?>
