<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 
/**
 * This file holds class Noticia
 * @package BIF3
 */

/**
 * Required includes
 */
global $sys_dir;
include_once("$sys_dir/Widgets/SQL/SQLList.php");

/**
 * News' list. if ID specified only show 1 news
 *
 * Specify the way Date is displayed with DateFormat, 
 * format is described in   http://www.mysql.com/doc/en/Date_and_time_functions.html
 *
 * @package  BIF3
 * @subpackage Widgets/Contents
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.1.2.1 $
 */
 
class Noticia extends SQLList {
  // {{{ function Constructor
  /**
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string ID a specific id, only shows that news
   * @parameter string DATEFORMAT Format to display 'date of publication' (Default: '%d/%m/%Y %H:%ihs.')
   */
  function __construct($attrs = array()) {
    if ($attrs['ID']) {	  
      $mas = "AND  id='${attrs['ID']}'";
    } else { 
      $mas ="";
    }
    if (! $attrs['DATEFORMAT'] ) {
      // see http://www.mysql.com/doc/en/Date_and_time_functions.html
      $attrs['DATEFORMAT'] = '%d/%m/%Y %H:%ihs.';
    }
    $formato =  $attrs['DATEFORMAT'];

    $attrs['QUERY'] = 
"SELECT
 Titulo,
 Imagen,
 Resumen,
 Contenido, 
 FROM_UNIXTIME(Fecha,'$formato') as Fecha,
 Fecha as orden
FROM
 noticias
WHERE
  habilitado=1
  $mas 
ORDER BY
  orden DESC";
    parent::__construct($attrs);
  } // }}}

  function parseRow($row) { 
    $contenido = nl2br($row['Contenido']);
    $this->tpl->setVariable('Contenido',$contenido);
  }  
}
// }}}
?>
