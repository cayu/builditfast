<?php
/* Archivo de configuracion de Skins de BiF3 
INFO-NAME       : Agenda
INFO-BIFNAME    : Agenda
INFO-AUTHOR     : Sergio Daniel Cayuqueo
INFO-EMAIL      : linuxvarela@yahoo.com.ar
INFO-DESCRIPTION: Skin para el sistema Agenda
*/

class SkinAgenda extends PEAR {

  var $reg = array();

  function SkinAgenda() {
   
    $this->PEAR(); // Agenda init.
    global $sys_dir,$app_dir;

    $this->path_dir = "$app_dir/Skins/Agenda/";// path of templates
    $this->path_url = 'Skins/Agenda/';         // URL useful for images and css
    $this->reg =                                // Agenda values..
       array(
//	     'WidgetName_ATTRIBUTE' => 'value',  // Example
	     );
  }

  function _SkinAgenda() {
    // Destructor
  }

  function resource($string,$type='_template') {
    if ($type == '_template') {
      $file = $this->path_dir . $string . ".tpl";
      if (file_exists($file)) {
	return($file);
      }else{
	return;
      }
    } 
    else if ($type == '_css') {
      $file= $this->path_url . 'css/' . $string . '.css';
      global $app_dir;
      if (file_exists("$app_dir/$file")) {
	return($file);
      }else{
	return;
      }
    }
    else if ($type == '_layout') {
      $file= $this->path_dir . 'layouts/' . $string . '.tpl';
      if (file_exists($file)) {
	return($file);
      }else{
	return;
      }
    } 
    else
      return $this->reg[$string . $type];
  }

}
?>