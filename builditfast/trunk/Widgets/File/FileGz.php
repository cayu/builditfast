<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class FileGz
 * @package  BIF3
 */
// {{{ class FileGz
/**
 * Shows a .gz file content
 *
 * @package  BIF3
 * @subpackage Widgets/File
 * @author   Cesar Roldan <cesar@hugoroldan.com.ar>
 * @version  $Revision: 1.4.26.3 $
 */

class FileGz extends BifWidget {

  //  {{{ function Constructor
  /**
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string PATH Path to file.
   */
  function __construct($attrs=array()) {
    parent::__construct($attrs);
  } // }}}

  function innerDraw() {
    $archivo=$this->attributes['PATH'];

    if (! is_readable($archivo) ){
       $this->warning =& new BifWarning(array("TEXT"=>"$file not a  readable file"));
       return;
    }
    
    # Highlight the content
    ob_start ();
    $content = readgzfile ($archivo);	
    ob_end_flush ();
    $this->tpl->setVariable('CONTENT', $content);
    
    }
} // }}}
?>