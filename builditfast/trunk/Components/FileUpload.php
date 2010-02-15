<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

class FileUpload extends Component{ 

  var $uploaddir; // directory with WRITE access
  var $defaultdir =  "incoming/";
  var $file; // dot bif to represent form
  var $filelimit; //file limit in bytes

  function __construct($id,$attrs){
    parent::__construct($id,$attrs);
  }

  function publicInit($mensaje = '')
    {
      list($this->uploaddir,
	   $this->filelimit) = $this->attributes;

      // default dir: incoming
      if (! $this->uploaddir) {
	$this->uploaddir = $this->defaultdir;
      }
      if (! $this->filelimit) {
	$this->filelimit = "30000";
      }

      // if it's relative we asume app_dir
      global $app_dir;
      if ( ! ereg("^/",$this->uploaddir)) {
	$this->uploaddir = $app_dir . "/" .$this->uploaddir ;
      }
      
      // just a little try (probably won't work, do it by hand)
      @chmod($this->uploaddir,'0777'); 
      if (is_dir($this->uploaddir) AND is_writable($this->uploaddir)) {
	global $app_dir;
	$dirs=array(
		    "$app_dir/Contenido",
		    dirname(__FILE__)
		    );	
	$this->file = file_exists_in(get_class($this).".bif",$dirs);
	$init =& render_file($this->file,array('ACTION'=>$this->logicalId . '.Next',
					       'FILELIMIT' => $this->filelimit,
					       'MESSAGE'=>$mensaje)); 
      } else {
	$init =& new BifWarning(array("TEXT"=>"FileUpload: '$this->uploaddir' is not a writeable directory. 
	<a href=\"?action=$this->logicalId.Init\">Check Again</a>"));
      }
      $this->actualView =  $init->draw();
    }

  function publicNext(){

    if ( $this->check() ) {

      $this->uploadfile = $this->uploaddir. '/' .$_FILES['userfile']['name'];
      if (move_uploaded_file($_FILES['userfile']['tmp_name'], $this->uploadfile)) {
	$message =  "Archivo '".$_FILES['userfile']['name']."' subido al servidor. ";
        $this->sendObservers('FileUpload');	    
      } else {
	$message =  "El archivo es inválido. ";
      }
      
    } else {
      $message =  "El archivo no es apropiado. ";
    }
    $init =& render_file($this->file,array('ACTION'=>$this->logicalId . '.Next',
					   'FILELIMIT' => $this->filelimit,
					   'MESSAGE'=>$message)); 
    $this->actualView =  $init->draw();
  }

  // Should be implemented on childs to check invalid files (example
  // childs only accept images : ImageUpdate)
  function check()  {
    return true;
  }
}
?>
