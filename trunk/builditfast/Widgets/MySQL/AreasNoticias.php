<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Gleducar - WEB
 * Gleducar - WEB is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds class AreasNoticias
 * @package BIF3
 */
/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/SQL/SQLList.php");

// {{{ class AreasNoticias
/**
 * lista de areas para las noticias, Kernel, Generales etc etc.
 *
 * @package  Widgets
 * @subpackage Widgets
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.1.2.2 $
 */

class AreasNoticias extends SQLList {

  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string QUERY a SQL query. default: query of all programs ordered
   * @parameter string WHERE an aditional restriction.
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);
  }
  // }}}
  function innerDraw() {

    if ( $this->attributes["WHERE"] ) { 
      $WHERE = " AND ( ". $this->attributes["WHERE"]  . " ) ";
    }

    if (! $this->attributes["QUERY"]) {
      $this->attributes["QUERY"] = 
"
SELECT
  areasnoticias.id,
  areasnoticias.Area,
  count(noticias.id) as cantidad
FROM
  areareasnoticias left join trabajo 
    on (areasnoticias.id = noticias.Area)
WHERE  areasnoticias.habilitado = '1' 
$WHERE
GROUP BY
  areasnoticias.id
ORDER BY
  areasnoticias.Area ASC  
";
    };

    parent::innerDraw();
  }
}
// }}}
?>