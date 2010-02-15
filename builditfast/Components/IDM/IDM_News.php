<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

global $sys_dir;
require_once("$sys_dir/Components/IDM/IDM.php");
class IDM_news extends IDM {

  function __contruct($id,$params = array()) {
    parent::__contruct($id, $params);
  }

  function publicInit() {
    $this->table               = 'noticias';
    $this->primaryKey          = array('id');
    $this->importantFields     = array('id','Titulo');
    $this->searchField         = 'Titulo';
    $this->active              = 'habilitado';
    $this->SQLRender           = 'Render_news';
    $this->update              = array('UpdateNews');
    $this->fields = array(
			  array('id',"int(11) NOT NULL auto_increment",
				'FTShow','','','',true),
			  array('Titulo',"VARCHAR( 40 ) NOT NULL",
				'FTText','',
				'check_alfanum','',true),
			  array('Fecha',"INT( 14 ) NOT NULL",
				'FTDateTime','',
				'check_num','',true),
			  array('Area',"INT( 11 ) NOT NULL",
				'FTAreasNoticias','','check_num','',true),
			  array('Imagen',"VARCHAR( 50 )",
				'FTDir','dir="uploaded-images"',
				'','',true),
			  // PALABRASCLAVES
			  array('PalabrasClaves',"varchar(250) default NULL",
				'FTText',
				'size="50" description="Palabras Claves: " help="Listado de palabras claves separadas por comas"',
				'check_alfanum','',true),
			  array('Resumen',"VARCHAR( 250 ) NOT NULL",
				'FTTextarea','ROWS="3" COLS="50"',
				'','',true),
			  array('Contenido',"TEXT NOT NULL",
				'FTTextarea','ROWS="20" COLS="50"',
				'','',true),
			  );
    parent::publicInit();
  }

  function stubFileUpload() {
    parent::publicInit();
  }


}

class Render_news {
  var $logicalID  = 'm_news';

  function Render_news() {
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
