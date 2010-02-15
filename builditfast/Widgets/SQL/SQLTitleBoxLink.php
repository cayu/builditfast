<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */
/**
 * This file holds class SQLTitleBoxLink
 * @package BIF3
 */

/**
 * needed includes
 */
global $sys_dir;
include_once("$sys_dir/Widgets/SQL/SQLList.php");

// {{{ class SQLTitleBoxLink
/**
 * TitleBoxLink in SQL
 *
 * SQLTitleBoxLink is a box with a defined title and link. Needs SQL Table:
 * <pre>
 * CREATE TABLE mytitleboxlink (
 *  title varchar(100) NOT NULL default '',
 *  href varchar(100) NOT NULL default '',
 *  descripcion varchar(255) NOT NULL,
 *  text varchar(255) NOT NULL,
 *  id int(4) NOT NULL auto_increment,
 *  habilitado tinyint(1) NOT NULL default '1',
 *  PRIMARY KEY  (id)
 *) TYPE=MyISAM;
 *
 * </pre>
 *
 * @package  BIF3
 * @subpackage Widgets/SQL
 * @author   Sergio Cayuqueo <sergio@linuxv.com.ar>
 * @version  $Revision: 1.1.2.1 $
 * @see SQLList
 */
class SQLTitleBoxLink extends SQLList {

      function __construct($attrs = array()) {
       $attrs['QUERY'] = "SELECT title,href,descripcion,text,id FROM sqltitleboxlink
       WHERE habilitado='1'";
       parent::__construct($attrs);
      }
		function preChilds() {

      if (! $this->attributes['BORDER'] ) {
            $this->attributes['BORDER']='0';
         }
      if (! $this->attributes['CELLPADDING'] ) {
            $this->attributes['CELLPADDING']='0';
	 }
      if (! $this->attributes['CELLSPACING'] ) {
            $this->attributes['CELLSPACING']='0';
         }
      if (! $this->attributes['BGCOLOR'] ) {
            $this->attributes['BGCOLOR']='#DDDDDD';
         }

      $this->HTMLfields = array('WIDTH','ALIGN','CELLPADDING','CELLSPACING','BORDER','BGCOLOR');
      }
		function parseRow($row) {
    		$contenido = nl2br($row['descripcion']);
		    $this->tpl->setVariable('descripcion',$contenido);
  }
}
?>
