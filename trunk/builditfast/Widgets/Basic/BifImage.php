<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 



/**
 * This file holds class BifImage
 * @package  BIF3
 */
// {{{ class BifImage
/**
 * Implements a Basic Image inclusion
 *
 * This is the inital class used for images, now we can use the
 * <img src="" /> tag in most cases, (a is an HTMLTag widget)
 *
 * @package  BIF3
 * @subpackage Widgets/Basic
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.14.26.3 $
 */

class BifImage extends BifWidget {
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string SRC Image's source.Must be specified and file must exists. 
   * @parameter string ALT Image's ALT.
   * @parameter string NAME Image's NAME.
   * @parameter string BORDER Image's border.
   * @parameter string ALIGN Alignment
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);
  }

  function innerDraw() {
    $file = $this->attributes["SRC"];

    if (ereg("(.*://)",$file,$regs)) {
      $this->warning =  &new BifWarning(array(
	"TEXT" => "SRC attribute invalid.(contains '$regs[1]')"));      
    } else if($file == "") {
      $this->warning =  &new BifWarning(array(
	"TEXT" => "SRC attribute not specified."));
    } else if (! file_exists($file)) {
      $this->warning =  &new BifWarning(array(
        "TEXT" => "$file doesn't exist."));
    } else {
      $tmp=getimagesize($file);
      $this->attributes["SIZE"]=$tmp[3];

      $this->RAWfields=array("SIZE"); 
      $this->HTMLfields=array("ALT","SRC","NAME","BORDER","ALIGN");
    }
  }
}
// }}}
?>
