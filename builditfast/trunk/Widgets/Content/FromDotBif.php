<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */
 
/**
 * This file hold class Draft
 * @package BIF3
 */

// {{{ class FromDotBif
/**
 * Content of the widget is the result of rendering .bif file
 *
 * This is an Abstract class (should make an 'extends FromDotBif' to use it).<br>
 * Example
 * <pre>
 * class MyClass extends FromDotBif 
 * {
 *   function MyClass($attrs = array()) {
 *     $this->FromDotBif($attrs);
 *   }
 * }
 * </pre>
 * by default will display Contenido/miclass.bif. <br>
 * With FILENAME and DIRS can chage the default filename to display. <br>
 * NOTE: If there are several dirs (attribute DIRS) will check where file exists.
 *
 * @package  BIF3
 * @subpackage Widgets/Contents
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.11.14.3 $
 */

class FromDotBif extends BifWidget 
{
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string FILENAME A .bif file to render (Default: <WidgetName>.bif)
   * @parameter string DIRS Coma separated values of dirs, where to look for FILENAME(Default: '$app_dir/Contenido').
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);
  }
  
  function draw() {
    if ($this->hasAccess()) {
      if (! $this->attributes["FILENAME"]  ) {
	$this->attributes["FILENAME"] = $this->widgetName . '.bif';
      }
      
      if (is_string($this->attributes["DIRS"]) && $this->attributes["DIRS"] != "") {
	$this->attributes["DIRS"] = implode(',',$this->attributes["DIRS"] );
      }

      if (! $this->attributes["DIRS"] ) {
	global $app_dir;
	$this->attributes["DIRS"] = array("$app_dir/Contenido",
					  "$app_dir/Content",
					  render_file(dirname(__FILE__)),
					  );
      }

      if ($filename = file_exists_in($this->attributes["FILENAME"],
				     $this->attributes["DIRS"])) {
	$links = render_file($filename); 
	return $links->draw();     
      } else {
	return "File ". $this->attributes["FILENAME"] .
	  " in ".implode (', ',$this->attributes["DIRS"]) .
	  " doesn't exists.";
      }
    }  else {
      return "<!-- WIDGET $this->widgetName without access -->\n" ;
    }
  }
}
?>