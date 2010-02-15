<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds class ResumenNoticias
 * @package BIF3
 */

/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/SQL/SQLList.php");

// {{{ class ResumenNoticias
/**
 * Brief news' list, similar to LasNoticias, diferent look (usuarlly more compact)
 *
 * Specify the way Date is displayed with DateFormat, 
 * format is described in   http://www.mysql.com/doc/en/Date_and_time_functions.html
 *
 * @package  BIF3
 * @subpackage Widgets/Contents
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.1.2.1 $
 */

class ResumenNoticias extends SQLList {
  //  {{{ function Constructor
  /**
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string FROM news to star from (Default: 0 - first) 
   * @parameter string MAX Maximum amount of news to be displayed (Default: 3)
   * @parameter string DATEFORMAT Format to display 'date of publication' (Default: '%d/%m/%Y')
   */
  function __construct($attrs = array()) {

    if ($attrs['FROM']) {
      $FROMNOTICIAS = $attrs['FROM'] ;
    } else {
      $FROMNOTICIAS = 0;
    }
    if ($attrs['MAX']) {
      $MAXNOTICIAS = $attrs['MAX'] ;
    } else {
      $MAXNOTICIAS = 3;
    }
    if (! $attrs['DATEFORMAT'] ) {
      // see http://www.mysql.com/doc/en/Date_and_time_functions.html
      $attrs['DATEFORMAT'] = '%d/%m/%Y';
    }
    $formato =  $attrs['DATEFORMAT'];

    $attrs['QUERY'] = 
"SELECT
 id,
 Titulo,
 Imagen,
 Resumen,
 FROM_UNIXTIME(Fecha,'$formato') as Fecha,
 Fecha as orden
FROM
 noticias
WHERE
 habilitado='1' order by orden DESC Limit $FROMNOTICIAS,$MAXNOTICIAS";

    parent::__construct($attrs);
  } // }}}
}// }}}
?>
