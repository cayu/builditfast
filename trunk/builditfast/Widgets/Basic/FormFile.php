<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class FormFile
 * @package  BIF3
 */
// {{{ class FormFile
/**
 * Form's file type field
 *
 * This is a Basic form widget, HTML's <input type="file">
 * 
 * @package  BIF3
 * @subpackage Widgets/Basic
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.2.6.3 $
 */

class FormFile extends BifWidget 
{
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string NAME  Name of the item
   * @parameter string VALUE 
   * @parameter string FILESIZE Max file size 
   */
  function __construct($attrs = array()) 
    {
      parent::__construct($attrs);
    }
  
  function innerDraw() 
    {
      $this->attributes['NAME'] .= '_file';
      
      if (!$this->attributes['FILESIZE']) {
	$this->attributes['FILESIZE'] = '1000000';
      }

      $this->HTMLfields=array("NAME","VALUE");
      $this->RAWfields=array("FILESIZE");
    }
}
// }}}
?>