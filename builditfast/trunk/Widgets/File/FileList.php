<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class FileList
 * @package  BIF3
 */
// {{{ class FileList
/**
 * Lists directory
 *
 * Is similar to 'ls DIR' or 'dir DIR'. you can filter 
 * with a REGEXP (regular expresion). The files are sorted 
 * (reverse version numbers style compare).
 * Example: 0.2.1 0.2 0.1.1 0.1 
 *
 * @package  BIF3
 * @subpackage Widgets/File
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.18.8.3 $
 */

class FileList extends BifWidget {

  //  {{{ function Constructor
  /**
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string DIR Directory where files are.
   * @parameter string MD5FILE md5sum file name
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
    $dir=$this->attributes['DIR'];

    if ( $this->attributes['MD5FILE'] ) {
      $md5_file = $this->attributes['MD5FILE'];
    } else {
      $md5_file   = "$dir/md5sum";
    }

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
	 if ("$dir/$file" != $md5_file) //exclude md5_file
	   array_push($list,$file);
       }
    }
    closedir($handle); 

    uasort($list,'myVersionCompare');


    if (file_exists($md5_file)) {
      $md5_mtime  = filemtime($md5_file);
    } else {
      $md5_mtime  = 0;
    }
    
    if ($md5_mtime < filemtime("$dir")){
      if (is_writable($md5_file)) {
	//generate md5
	$md5_fp = fopen($md5_file,'w');
	foreach ( $list as $tmp) {
	  fwrite($md5_fp,md5_file("$dir/$tmp")."  $tmp\n");
	}
	fclose($md5_fp);      
      }
    }

    if (file_exists($md5_file)) {
      $this->tpl->setVariable('MD5SUM',"<a href=\"$md5_file\">all md5sum</a>");
    } else {
      $this->tpl->setVariable('MD5SUM',"Can't generate $md5_file");
    }
    

    foreach ($list as $file) {
      $file_p = $this->attributes['DIR'] . '/' .$file;
      $this->tpl->setVariable('NAME',$file);
      if (filemtime($file_p) > (time() - 64800)) {
	$this->tpl->setVariable('EXTRA','<font size="-1"><b>New!</b></font>');
      }
      $this->tpl->setVariable('FILE', $file_p);

      $file_size = filesize($file_p) / 1024;
      $this->tpl->setVariable('SIZE', round($file_size).' KB');

      $this->tpl->setVariable('DATE', date("d-M-Y", filemtime($file_p)));
      // FIXME: spends too much CPU time. cache should be used
      //      $this->tpl->setVariable('MD5SUM', md5_file($file_p));
      $this->tpl->parse("ROW");	
      $this->HTMLfields = array('WIDTH','ALIGN','CELLPADDING','CELLSPACING','BORDER','BGCOLOR');
    }
  }
} // }}}

function myVersionCompare($a,$b) {
  
  ereg("-([0-9\.]+)",$a,$regs);
  $version_a = explode('.',$regs[1]);
  
  ereg("-([0-9\.]+)",$b,$regs);
  $version_b = explode('.',$regs[1]);
  
  $tope = min(sizeof($version_a),sizeof($version_b));
  $b=0;
  while ($b < $tope + 1) {
    if ( $version_a[$b] > $version_b[$b]) {
      return -1;
    }
    if ( $version_a[$b] < $version_b[$b]) {
      return 1;
    }
    $b++;
  }
  
  // no importa son iguales
  return 0;
}
?>