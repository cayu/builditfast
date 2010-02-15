<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class BifTimestamp
 * @package  BIF3
 */
// {{{ class BifTimestamp
/**
 * Prints timestamps with a specific format
 *
 * It uses date (http://ar.php.net/date) internally so it's flexible to express
 * any date.
 *
 * @package  BIF3
 * @subpackage Widgets/Basic
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.7.26.3 $
 */

class BifTimestamp extends BifWidget 
{
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string VALUE Timestamp
   * @parameter string FORMAT Date format like. default %d-%m-%Y (http://ar.php.net/date)
   */
  function __construct($attrs = array()) 
    {
      parent::__construct($attrs);
    }
  
  function innerDraw() 
    {
      if ( ! $this->attributes["FORMAT"] ) {
	$this->attributes["FORMAT"] = "%d-$m-%Y";
      } 
      
      $this->attributes["TEXT"] = 
	date($this->attributes["FORMAT"],
	     $this->attributes["VALUE"]);
      $this->RAWfields=array("TEXT");
    }
}
// }}}
?>