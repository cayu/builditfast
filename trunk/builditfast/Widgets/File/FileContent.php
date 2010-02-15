<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class FileContent
 * @package  BIF3
 */
// {{{ class FileContent
/**
 * Shows file contents
 *
 * @package  BIF3
 * @subpackage Widgets/File
 * @author   Cesar Roldan <cesar@hugoroldan.com.ar>
 * @version  $Revision: 1.5.26.3 $
 */

class FileContent extends BifWidget {

  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string PATH Path to file.
   * @parameter string 	COLOR "true" in case you want to use colors
   */
  function __construct($attrs=array()) {
    parent::__construct($attrs);
  } // }}}

  function innerDraw() {
    $archivo=$this->attributes['PATH'];
    $encolor=$this->attributes['COLOR'];

    if (! is_readable($archivo) ){
       $this->warning =& new BifWarning(array("TEXT"=>"$file not a readable file"));
       return;
    }
    
    $fp = fopen($archivo,'r');
    $texto = fread($fp, filesize($archivo));

    if ( strncasecmp ( $encolor , 'TRUE', 4) == 0 ) { 
      $texto = highlight_string("<? ".$texto." ?>",TRUE);
      $texto = ereg_replace( "&lt;\?" , "" , $texto );
      $texto = ereg_replace( "\?&gt;" , "" , $texto );
    } else {
      $texto = show_source($archivo, TRUE);
    }

    $this->tpl->setVariable('TEXTO', $texto);
    
    }
} // }}}
?>