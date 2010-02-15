<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds the FTDir class
 * @package BIF3
 */


/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/FT/FTItem.php");

// {{{ class FTDir
/**
 * Shows a directory content on a FormSelect widget, as a FTItem.
 *
 * @package    BIF3
 * @subpackage Widgets/FT
 * @author     Nicolás D. César <ncesar@lunix.com.ar>
 * @version    $Revision: 1.8.6.3 $
 * @see        FTItem
 * @see        FormSelect
 */
class FTDir extends FTItem {
  /** {{{ function FTDir
   * 
   * Instantiate a FTDir widget.
   *
   * This constructor inherits attributes from FTItem: DESCRIPTION,
   * ITEM, HELP and ERROR.
   *
   * @parameter $attrs Instance's attributes specified as a hash in CAPS.
   * @parameter string DIR Directory to list.
   * @parameter string REGEXP Regular expression to match files.
   */
  function __construct($attrs = array()) {    
    $this->widgetName='ftitem';
    parent::__construct($attrs);

    $this->item =& new FormSelect($this->attributes);

    $dir=$this->attributes['DIR'];
    $regexp=$this->attributes['REGEXP'];
    $handle=opendir($dir);
    // ignore . and ..
    readdir($handle);
    readdir($handle);
    $list=array();
    while ($file = readdir($handle)){
       if ($regexp=="" OR ereg($regexp,$file)) { 
	 array_push($list,$file);
       }
    }
    closedir($handle); 

    sort($list);
    foreach ($list as $file) {
      $this->addOption($file,$file);
    }
  } // }}}

  function addOption($value, $desc, $selected=false) {
    $this->item->addOption($value, $desc, $selected);
  }

  function addChild(&$obj) {
    $this->item->addChild($obj);
  }
} // }}}

?>
