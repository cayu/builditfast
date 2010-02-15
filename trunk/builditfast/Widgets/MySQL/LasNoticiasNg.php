<?php
/**
 * This file holds class LasNoticiasNg
 * @package BIF3
 */
/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/SQL/SQLList.php");
// {{{ class LasNoticiasNg
/**
 * Remake de LasNoticias con division por columnas
 *
 * @package  BIF3
 * @subpackage Widgets/Contents
 * @author   Sergio Cayuqueo <linuxvarela@yahoo.com.ar>
 * @version  $Revision: 1.1.2.6 $
 */


class LasNoticiasNg extends BifWidget {
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string MAX Maximum amount of news to be displayed (Default: 3)
   * @parameter string FROM news to star from (Default: 0 - first) 
   * @parameter string WHERE an aditional restriction.
   * @parameter string NUM numero de columnas a generar
   * @parameter string DATEFORMAT Format to display 'date of publication' (Default: '%d/%m/%Y %H:%ihs.')
   */
  function __construct($param = array()) {
    parent::__construct($param);
  }
  function innerDraw() {
      if ($this->attributes['NUMCOLS']) {
          $numcols=$this->attributes['NUMCOLS'];
      } else {
          $numcols="2";
      }
    if ($attrs['FROM']) {
      $FROMNOTICIAS = $attrs['FROM'] ;
    } else {
      $FROMNOTICIAS = 0;
    }

    if ($attrs['MAX']) {
      $MAXNOTICIAS = $attrs['MAX'] ;
    } else {
      $MAXNOTICIAS = 8;
    }
    if ( $attrs["WHERE"] ) { 
      $WHERE = " AND ( ". $attrs["WHERE"]  . " ) ";
    }
    if (! $attrs['DATEFORMAT'] ) {
      // see http://www.mysql.com/doc/en/Date_and_time_functions.html
      $attrs['DATEFORMAT'] = '%d/%m/%Y %H:%ihs.';
    } 
    $formato =  $attrs['DATEFORMAT'];
    $result = $_SESSION['_BifApplication']->execQuery("SELECT 
     *,FROM_UNIXTIME(Fecha,'$formato') as Fecha
     FROM noticias,areasnoticias 
     WHERE noticias.Area = areasnoticias.id AND
     noticias.habilitado = '1' AND
     areasnoticias.habilitado = '1'
     $WHERE
     order by Fecha DESC Limit $FROMNOTICIAS,$MAXNOTICIAS");
  for ($i = 1 ; $row = $result->fetchRow(DB_FETCHMODE_ASSOC) ; $i++)  {
     $mod = $i % $numcols;
         if ($mod == 1) $this->tpl->setVariable('TR1','<tr>');
	    $this->tpl->setVariable('TD1',"<td>");
	    $this->tpl->setVariable('TD2',"</td>");
         if ($mod == 0) $this->tpl->setVariable('TR2','</tr>');
		$keys = array_keys($row);
	    	foreach($keys as $key) {
		    $this->tpl->setVariable($key,$row[$key]);         
		 }
	 $this->tpl->parse('item');
	    }
	 if ($mod <> 0) $this->tpl->setVariable('TD','</tr>');
    $this->HTMLfields = array();
    parent::innerDraw();
  }

}
?>
