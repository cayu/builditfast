<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class FilePhp
 * @package  BIF3
 */
// {{{ class FilePhp
/**
 * Shows a .php file (syntax color highlight)
 *
 * @package  BIF3
 * @subpackage Widgets/File
 * @author   Cesar Roldan <cesar@hugoroldan.com.ar>
 * @version  $Revision: 1.6.14.3 $
 */

class FilePhp extends BifWidget {

  // {{{ function Constructor
  /** 
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string PATH Path to file.
   */
  function __construct($attrs=array()) {
    parent::__construct($attrs);
  } // }}}

  function innerDraw() {
    $file=$this->attributes['PATH'];

    if (! is_readable($file) ){
       $this->warning =& new BifWarning(array("TEXT"=>"$file not a  readable file"));
       return;
    }
    
    # Highlight the content
    $texto = highlight_file($file,TRUE);

    $this->tpl->setVariable('TEXTO', $texto);
  } 
} // }}}
?>