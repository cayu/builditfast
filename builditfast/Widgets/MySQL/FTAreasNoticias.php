<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Gleducar - WEB
 * Gleducar - WEB is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 
 global $sys_dir;
  require_once("$sys_dir/Widgets/FT/FTSQLSelect.php");
  

/**
 * This file holds class FTAreasNoticias
 * @package  BIF3
 */

// {{{ class FTAreasNoticias
/**
 * A FT selection containing all 'tipos ' ordered by name.
 *
 * @package  Widgets
 * @subpackage Widgets
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.1.2.2 $
 */

class FTAreasNoticias extends FTSQLSelect {
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string EXTRA aditional selections: default '- choose one -'
   */
  function __construct($params = array()) {
    $params['QUERY'] = 
"select 
  id,
  Area
from
  areasnoticias
where
  habilitado='1' 
 order by(Area)";
    $params['EXTRA'] = "- Elegir una -," . $params['EXTRA'];
    parent::__construct($params);
  } // }}}

} // }}}

?>