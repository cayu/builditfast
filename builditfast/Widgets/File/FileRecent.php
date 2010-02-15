<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class FileRecent
 * @package  BIF3
 */
// {{{ class FileRecent
/**
 * From a given directory, it shows only last modified file.
 *
 *  You can filter 
 * with a REGEXP (regular expresion). 
 *
 * @package  BIF3
 * @subpackage Widgets/File
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.1.14.3 $
 */

class FileRecent extends BifWidget {

  //  {{{ function Constructor
  /**
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string DIR Directory where files are.
   * @parameter string REGEXP filter to use. (ex. "\.tgz$")
   * @parameter string WIDTH
   * @parameter string ALIGN
   * @parameter string CELLPADDING
   * @parameter string CELLSPACING
   * @parameter string BORDER
   * @parameter string BGCOLOR
    }
   */
  function __construct($attrs=array()) {
    parent::__construct($attrs);
  } // }}}

  function innerDraw() {

    if (! $this->attributes['MAX']) {
      $this->attributes['MAX'] = 1;
    };
    $dir=$this->attributes['DIR'];
    $regexp=$this->attributes['REGEXP'];

    if (! (is_dir($dir) AND is_readable($dir)) ){
       $this->warning =& new BifWarning(array("TEXT"=>"$dir not a redeable
       directory"));
       return;
    }	
    $handle=opendir($dir);
     // ignore . and ..
     readdir($handle);
     readdir($handle);
     $list=array();
     while ($file = readdir($handle)){
       if ($regexp=="" OR ereg($regexp,$file)) {  
	 $list[filectime("$dir/$file")]=$file;	
       }
    }
    closedir($handle); 

    krsort($list);
    $c = 0;
    while ($c < $this->attributes['MAX']) {
      $file = array_shift($list);
      $file_p = $this->attributes['DIR'] . '/' .$file;
      $this->tpl->setVariable('NAME',$file);
      if (filemtime($file_p) > (time() - 64800)) {
	$this->tpl->setVariable('EXTRA','<font size="-1"><b>New!</b></font>');
      }
      $this->tpl->setVariable('FILE', $file_p);

      $file_size = filesize($file_p) / 1024;
      $this->tpl->setVariable('SIZE', round($file_size).' KB');

      $this->tpl->setVariable('DATE', date("d-M-Y", filemtime($file_p)));
      $this->tpl->parse("ROW");	
      $this->HTMLfields = array('WIDTH','ALIGN','CELLPADDING','CELLSPACING','BORDER','BGCOLOR');
      $c++;
    }
  }
} // }}}

?>