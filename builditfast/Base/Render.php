<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

global $pear_dir;
require_once("$pear_dir/HTML/Template/Sigma.php");
// Pila temporal para hacer las asignaciones
// de las relaciones paternales entree objetos.
// cuando termina el render, $elementos debe estar
// vacio.

$elementos 	= array();
$render_root  	= array();

// $trans_table is global for optimization problems
$trans_table = array_flip(get_html_translation_table(HTML_ENTITIES));
function html2specialchars($str){
  global $trans_table;
  return strtr($str, $trans_table);
}
function debug_entities($str) {
  return ereg("\&",$str);
}
function startElement($parser, $name, $attrs) {
  global $elementos;
  global $classes;

  if (in_array(strtoupper($name),$GLOBALS['HTMLVALs'])) {
    $obj =& new HTMLTag(array_merge($attrs,array('TAG'=>"$name")));
  }  else {
    // crea un objeto de la clase $name con $attrs como
    // parametros.
    if(! class_exists(strtolower($name))){
    	 die("Error: Widget $name not found<br>");
    }    
    $obj =& new $name(array_map(html2specialchars,$attrs));
    $good=array_filter($attrs,debug_entities);
    if (! empty($good)) {
//      print_r($good);
    }
    //$obj =& new $name($attrs);
  }

  // mete $obj en la lista
  array_push($elementos[$parser], &$obj);

  // A partir del 2do elemento, se vincula el actual con su padre
  $size = sizeof($elementos[$parser]);
  if ($size > 1) {

    // EN CASO que no exista el addChild (ejemplo un widget que se
    // pretende meter texto)
    
    if (! method_exists($elementos[$parser][$size - 2],'addchild')) {
      $parent = get_class($elementos[$parser][$size - 2]);
      $line   = xml_get_current_line_number($parser);
      die("Error: '$parent' is not a Container (line $line) <br>");
    }

    if ( isset($attrs['AT']) ){
      $elementos[$parser][$size - 2]->addChild($elementos[$parser][$size - 1],$attrs['AT']);
    }else{
      $elementos[$parser][$size - 2]->addChild($elementos[$parser][$size - 1]);
    }
  }
}

function endElement($parser, $name) {
  global $elementos;
  global $render_root;

  $render_root[$parser]=array_pop($elementos[$parser]);
}

function characterData($parser, $data) {
  if ((ereg('[[:print:]]+',$data))) {
    startElement($parser,'BifRawText', array('TEXT'=>$data . "\n"));
    endElement($parser,'BifRawText');
  }
}

function replaceArray(&$tpl,$replace,$prefix='') {
  while (list($token,$text) = each($replace)) {
    if (is_array($text)) {
      replaceArray($tpl,$text,$token);
    } else {
      $tpl->setVariable($prefix . $token,"$text");
    }
  }
}

function &render_file($arch,$replace = array()) {
  if ($replace == array()) {
    if (!($fp = fopen($arch, 'r'))){
      //return ;
      die("FATAL ERROR: Can't open file <b>$arch</b> for reading.");
    }  
    $tmp = fread($fp,filesize($arch) );
    fclose($fp);
  } else {
    global $app_dir;
    $tpl =& new HTML_Template_Sigma('',$app_dir."/cache/tpl/");
    $tpl->loadTemplatefile($arch);
    
    replaceArray($tpl,$replace);

    $tmp = $tpl->get();
  }
  return render($tmp);

}

function &render($data,$replace = array()) {
  global $elementos;
  global $render_root;

  if ($replace != array()) {
    global $app_dir;
    $tpl =& new HTML_Template_Sigma('',$app_dir."/cache/tpl/");
    $tpl->setTemplate($data);
    replaceArray($tpl,$replace);
    $tpl->parse();
    $data = $tpl->get();
  }


  $xml_parser = xml_parser_create();
  $elementos[$xml_parser]= array();
  $render_root[$xml_parser]= "";

  xml_set_character_data_handler($xml_parser, 'characterData');
  xml_set_element_handler($xml_parser, 'startElement', 'endElement');
  
  $tamano= strlen($data);
  if (!xml_parse($xml_parser, $data )) {
    $index = xml_get_current_byte_index($xml_parser);
    $tmp = substr($data,$index - 30,60);
    die(sprintf("Error XML: %s en la linea %d<br>------<pre>%s</pre><br>-----", 
		xml_error_string(xml_get_error_code($xml_parser)),
		xml_get_current_line_number($xml_parser),
		htmlentities($tmp)
		));
  }
  
  xml_parser_free($xml_parser);
  return ($render_root[$xml_parser]);
}

?>