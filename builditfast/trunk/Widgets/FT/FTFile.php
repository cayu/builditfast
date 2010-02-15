<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds the FTFile class
 * @package BIF3
 */

/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/FT/FTItem.php");

// {{{ class FTFile
/**
 * A widget to send a file 
 *
 * 
 * NOTE: You can use the Application::getParameter() method like this:
 *
 * $content =  $_SESSION['_BifApplication']->getParamenter('MyVar');
 *
 * $content will contain the contents of the file sended and:
 *
 * $file    =  $_SESSION['_BifApplication']->getParamenter('MyVar_file'); (??)
 *
 * $file will be a temporary file (usually in /tmp/) containing file contents
 * 
 *
 * @package    BIF3
 * @subpackage Widgets/FT
 * @author     Nicolás D. César <ncesar@lunix.com.ar>
 * @version    $Revision: 1.3.6.3 $
 * @see        FTItem
 */
class FTFile extends FTItem {
  // {{{ function FTFile
  /** 
   * Instantiate a FTFile widget.
   *
   * This constructor inherits attributes from FTItem: DESCRIPTION,
   * ITEM, HELP and ERROR.
   *
   * @parameter $attrs Instance's attributes specified as a hash in CAPS.
   * @parameter string NAME Variable's name.
   * @parameter string VALUE (?)
   */
  function __construct($attrs = array()) {
    $this->widgetName="ftitem";
    parent::__construct($attrs);

    if (isset($this->attributes['VALUE'])) {
      // wtf: what's a value anyway
    }

      $this->item =& new FormFile(array(
					'NAME' =>  $this->attributes['NAME'], 
					'VALUE' =>  $this->attributes['VALUE'],
					)
				  );
  } // }}}
} // }}}

?>
