<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class FileBz2
 * @package  BIF3
 */
// {{{ class FileBz2
/**
 * Shows a .bz2 file content
 *
 * @package  BIF3
 * @subpackage Widgets/File
 * @author   Cesar Roldan <cesar@hugoroldan.com.ar>
 * @version  $Revision: 1.6.26.3 $
 */

class FileBz2 extends BifWidget {

  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string PATH Path to file.
   * @parameter string BYTES Bytes to read from file
  */
  function __construct($attrs=array()) {
    parent::__construct($attrs);
  } // }}}

  function innerDraw() {
    $archivo=$this->attributes['PATH'];
    $bytes=$this->attributes['BYTES'];

    if (! is_readable($archivo) ){
       $this->warning =& new BifWarning(array("TEXT"=>"$file not a  readable file"));
       return;
    }
    
    # Highlight the content
    $file = bzopen ($archivo, "r");
    $content = bzread ($file,$bytes);
    $this->tpl->setVariable('CONTENT', $content);
    
    }
} // }}}
?>