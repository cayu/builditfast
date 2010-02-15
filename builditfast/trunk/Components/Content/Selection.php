<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

class Selection extends Component{ 

  var $botones = array();

  function __construct($id,$attrs=array()){
    parent::__construct($id,$attrs);
  }

  function publicInit() {
    list($this->path,
	 $botones,
	 $this->dirs,
	 $this->filename)=$this->attributes;
    // BUG: $this->path no se está estableciendo correctamente.
    // revisar Componente  Información  de Avina

    if (! $this->path ) {
      global $app_dir;
      $this->path = "$app_dir/Contenido";
    }

   if ( ! $botones ) {
     $handle=opendir($this->path);
     // ignore . and ..
     readdir($handle);
     readdir($handle);
     while ($file = readdir($handle)){
       if (ereg("(.*)\.bif\$",$file,$regs)) { 
	 array_push($this->botones,array($file,$regs[1]));
       }
     }
   } else {
     $tmp=explode(',',$botones);
     foreach ($tmp as $btn) {
       array_push($this->botones,explode(':',$btn));
     }
   }

    if (! $this->filename  ) {
      $this->filename = get_class($this) . '.bif';
    }

    if (! $this->dirs ) {
      global $app_dir;
      $this->dirs = "$app_dir/Contenido,". dirname(__FILE__);
    }
    /*    if (! is_array($this->dirs) && $this->dirs != "") {
      $this->dirs = implode(',',$this->dirs );
    }
    */

    if ($filename = file_exists_in($this->filename,
				   $this->dirs)) {
      $this->render_file = $filename; 
    } else {
      if (file_exists(dirname(__FILE__)."/selection.bif")) {
	$this->render_file = dirname(__FILE__)."/selection.bif";
      } else {
	$this->actualView = "File ". $this->filename .
	  " in " . $this->dirs .
	  " doesn't exists.";
	return;
      }
    }
    // $this->render_file has the name for the template:

    $this->tpl =& new HTML_Template_Sigma('',"/tmp/tpl-cache/");

    $this->tpl->loadTemplatefile($this->render_file);
    foreach($this->botones  as $btn) {
      list($file,$desc) = $btn;
      if ($desc=='') {
	$desc = $file;
      }
      $this->tpl->setVariable("TEXT",$desc);
      $this->tpl->setVariable("HREF","?action=$this->logicalId.Seleccion&amp;s=" . $file);
      $this->tpl->parse("ITEM");
    }
    $this->tpl->setVariable("CONTENTS","Contenido");
    if (PEAR::isError($this->tpl->get())) {
      $err=$this->tpl->get();
      $this->actualView = $err->getMessage();
    } else {
      $widget = render($this->tpl->get());
      $this->actualView = $widget->draw();
    }
  }

  function publicSeleccion() {
    $selec=$_SESSION['_BifApplication']->getParameter('s');

    $tmpcheck =array();
    foreach($this->botones as $b)
      array_push($tmpcheck, $b[0]);

    if (! in_array($selec,$tmpcheck))  
    {
      $contenido = 'Requested page doesn\'t exists';
    } else {
      //$contenido = file_get_contents("$this->path/$selec");  // Implemented in PHP 4.3.0
      $contenido = '';
      if( $contenido_file = fopen("$this->path/$selec","r")){ 
	while (! feof($contenido_file)) {
	  $contenido .= fgets($contenido_file,4096);
	}
	fclose($contenido_file);
      } else {
	$contenido ="Can't find $this->path/$selec";
      }
    }

    $this->tpl =& new HTML_Template_Sigma('',"/tmp/tpl-cache/");

    $this->tpl->loadTemplatefile($this->render_file);
    foreach($this->botones  as $btn) {
      list($file,$desc) = $btn;
      if ($desc=='') {
	$desc = $file;
      }
      $this->tpl->setVariable("TEXT",$desc);
      if ($file == $selec) {
	$this->tpl->setVariable("HREF","");
      } else {
	$this->tpl->setVariable("HREF","?action=$this->logicalId.Seleccion&amp;s=" . $file);
      }
      $this->tpl->parse("ITEM");
    }
    $this->tpl->setVariable("CONTENTS",$contenido);


    if (PEAR::isError($this->tpl->get())) {
      $err=$this->tpl->get();
      $this->actualView = $err->getMessage();
    } else {
      $widget = render($this->tpl->get());
      $this->actualView = $widget->draw();
    }
  }
}
?>
