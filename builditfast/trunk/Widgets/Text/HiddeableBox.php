<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class HiddeableBox
 * @package  BIF3
 */
// {{{ class HiddeableBox
/**
 * A box with a button to hide and unhide using javascript
 *
 * 
 * @package  BIF3
 * @subpackage Widgets/Text
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.1.14.3 $
 */

class HiddeableBox extends BifContainer {

  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string TEXT title
   */
  function __construct($attrs = array()) 
    {
      parent::__construct($attrs);
    }

  function preChilds() 
    {

      if (! $this->attributes['ID'] ) {
	$rand =  chr(rand(1,25)+97).chr(rand(1,25)+97).chr(rand(1,25)+97)
	.chr(rand(1,25)+97).chr(rand(1,25)+97).chr(rand(1,25)+97);
	$this->attributes['ID']=$rand;
      }

      $this->RAWfields= array('TEXT','ID');
    }
}
?>