<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF). 
 * Build It Fast is distributed under the terms of 
 * the GNU General Public License (GNU GPL)
 */
global $pear_dir;
require_once ("DB.php");
/**
 * This file holds class Application
 * @package BIF3
 */

// {{{ class Application
/**
 * The 'one and only' object that has session information
 *
 * Application  is the class for $_SESSION['_BifApplication'] object
 * 
 * @package  BIF3
 * @subpackage Base
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.54.2.4 $
 */
class Application extends PEAR 
{
  // {{{ properties

  /**
   * List of the components
   */
  var $components=array();

  /**
   * Global vars stored in the registry
   */
  var $vars=array();
  /**
   * The skins defined in the application
   */
  var $skins=array();        

  /**
   * Default filename for mapping file
   */
  var $mapfile='mapping.txt';

  /**
   * mapfile's timestamp for update checking
   */
  var $mapfile_timestamp=0;

  /**
   * Holds Databse conection object.
   */
  var $database;

  /**
   * internal checking
   *
   * @access private
   */
  var $_init = false;

  // }}}


  // {{{ Constructor

  /**
   * 
   */
  function __construct()
    {
      parent::PEAR();
    }
  // }}}

  // {{{ Destructor

  // {{{ loadAllComponents()

  /**
   * Loads all components form mapfile.
   *
   * It should only  do it once per session unless mapfile changed. 
   * 
   * @access public
   * @param  string $config_file config file 
   * @return void
   */
  function loadAllComponents($config_file = '') 
    {
      global $app_dir;
      if ($config_file == '') {
	$config_file=$app_dir . '/' . $this->mapfile;
      }

      if  ($this->mapfile_timestamp == filemtime($this->mapfile)) {
	return;
      }
    
      /* Reading the mapping file */
      if(!file_exists($config_file))
	die("Mapping file:  $config_file doesn't exist\n");

      if(!$fp=@fopen($config_file,'r'))
	die("Can't open mapping file:  $config_file\n");

      $this->components=array();

      while (!feof($fp)) {
	$line=fgets($fp,4000);
	if (! ereg('^ *#',$line) && $line!='') { 
	  list($logicalId,$component,$observers)=explode(':',$line);
	  $component=chop($component);
	  $parameters=array();
	  if (ereg('(.*)\((.*)\)',$component,$regs)) {
	    $component  = $regs[1];
	    $parameters = explode(';',$regs[2]);
	  } 
	  if(!class_exists($component)){
	    die("can't load component '$component'");
	  }
	  $this->components[$logicalId] =& new $component($logicalId,$parameters);
	  $observers=explode(',',$observers);
	  foreach($observers as $obs) {
	    list($ob,$stub)=explode('.',$obs);
	    // TODO: better error reporting
	    $this->components[$logicalId]->addObserver(chop($ob),chop($stub));
	  }
	}
      }
      fclose($fp);
      $this->_init = true;
      $this->mapfile_timestamp=filemtime($config_file);
    }
    // }}}

  // {{{ initAllComponents()

  /**
   * Initialize all Components
   *
   * execs publicInit() of each components so they have an
   * initial representation 
   */
  function initAllComponents() {
    $keys = array_keys($this->components);
    $size = sizeOf($keys);
    // for each position
    for ($ind=0; $ind < $size; $ind++) {
      $componente=&$this->components[$keys[$ind]];
      $componente->publicInit();
    }
  }
  // }}}

  // {{{ skin()
  /**
   * skin resources 
   * 
   * @access public
   * @param  string $resource
   * @param  string $type
   * @return string
   */
  function skin($resource,$type = '_template')
    {	  

      if (!($szSkins = sizeof($this->skins)))
	die("Attemting to get resourse '$resource$type', but there's no skin loaded.");

      $return = '';
      // Search for resource
      for($index = 0; $index < $szSkins; $index++) {
	$return = $this->skins[$index]->resource($resource,$type);
	if($return != '') {
	  break;
	}
      }
      return $return;
    }
  // }}}
  // execAction()

  /**
   * Execs a public option
   *
   * @param string $action "component.function" to exec component->publicFunction()
   */
  function execAction($action = '')
    {
      if (!$action){
	$action = $_REQUEST['action'];
      }
      if ($action){
	// the action is a  "component.function"
	list( $logicalId , $function ) = explode('.',$action);

	$tmp =& $this->getComponent($logicalId);
	$tmp->callMethod($function);
      }
    }
  // }}}

  // {{{ getComponent()
  /**
   *
   */
  function &getComponent($logicalId) 
    {
      if ( isset($this->components[$logicalId]) ) {
	return $this->components[$logicalId];
      } else {
	die("Can't find componente $logicalId");
      }
    }
  // }}}


  // {{{ setVar()
  /**
   * setVar() is used to store aplication global variables
   *
   * @param string $key A string to use as 'key' for storing
   * @param mixed $value The value to store in sesion
   * @return void
   */
  function setVar($key,$value)
    {
      $this->vars[$key]=$value;
    }
  // }}}

  // {{{ getVar()
  /**
   * getVar() is used to retrive an stored value with setVar()
   * 
   * @param string $key  A string to use as 'key' for retriving
   * @return mixed The value stored in session
   */
  function &getVar($key)
    {
      if ($this->vars[$key]) {
	return($this->vars[$key]);
      } else { 
	return "";
      }
    }
  // }}}
  // {{{ unSetAll($prefix) 
  /**
   * un-sets variable starting with $prefix
   *
   * you can organize variables with a given prefix such as user
   * ex. user_name, user_level, user_keys and when she logs out, 
   * erase all with unSetAll('user')
   * 
   * @param string $prefix A string to use as prefix to unset variables
   *
   * @return void
   */
  function unSetAll($prefix) {   
    foreach(array_keys($this->vars) as $a )
      if(! strncmp($a,$prefix,sizeof($prefix))) { // true == 0 
	unset($this->vars[$a]);
      }
  }
  // }}}
  // {{{ getParameter()
  /**
   *  getParameter() is used for retriving GET or  POST variables.
   *
   * the BIF programmer shound only use Application::getParameter() and never
   * $_POST[] or $_GET[] directlly. Future implementations could handle different
   * method such http://server/script.php/parameter1=value1/parameter2=value2
   * or  http://server/script.php/value1/value2 very usefull for search engines
   * 
   * @param string $param the string of the parameter
   * @return mixed
   */
  function getParameter($param){

    // BACKWARD COMPATIBILITY 
    // (Should be removed)
    // version 0.2.x 
    // ----------
    if (ereg('date(.*)',$param,$regs)){
      $name =     $regs[1]  ;
      $dia=$_REQUEST[$name.'_dia'] ;
      $mes=$_REQUEST[$name.'_mes'] ;
      $ano=$_REQUEST[$name.'_ano'] ;
      $tmp = mktime(0,0,0,$mes,$dia,$ano);
      return $tmp;
    }
    // -----------

    if ( $fileInfo=$_FILES[$param.'_file'] ) {
      bif_debug('getting '.$param.'_file contents:',2);
      bif_debug($_FILES,2);

      return util_file_get_contents($fileInfo);
    }

    if (ereg('(.*)_filename$',$param,$regs)){
      $fileInfo=$_FILES[$regs[1].'_file'];
      return $fileInfo['name'];
    }
    if (ereg('(.*)_filesize$',$param,$regs)){
      $fileInfo=$_FILES[$regs[1].'_file'];
      return $fileInfo['size'];
    }
    if (ereg('(.*)_filetype$',$param,$regs)){
      $fileInfo=$_FILES[$regs[1].'_file'];
      return $fileInfo['type'];
    }

    if ( $dia=$_REQUEST[$param.'_dia'] AND 
	 $mes=$_REQUEST[$param.'_mes'] AND
	 $ano=$_REQUEST[$param.'_ano'] ) {
      $tmp = mktime($_REQUEST[$param.'_hora'],$_REQUEST[$param.'_min'],$_REQUEST[$param.'_sec'],$mes,$dia,$ano);
      return $tmp;
    } 

    if ( $dia=$_REQUEST[$param.'_mydia'] AND 
	 $mes=$_REQUEST[$param.'_mymes'] AND
	 $ano=$_REQUEST[$param.'_myano'] ) {
      $mes=sprintf("%02d",$mes);
      $dia=sprintf("%02d",$dia);
      $tmp = "$ano-$mes-$dia";      
      if ($hora= $_REQUEST[$param.'_myhora'] AND
	  $min = $_REQUEST[$param.'_mymin']) {
	$hora=sprintf("%02d",$hora);
	$hora=sprintf("%02d",$min);
	$tmp .= " $hora:$min:00";
      }
      return $tmp;
    } 

    if (isset($_REQUEST[$param.'_ph1']) AND
	isset($_REQUEST[$param.'_ph2']) AND
	isset($_REQUEST[$param.'_ph3']) ) {

      $phone1=$_REQUEST[$param.'_ph1'];
      $phone2=$_REQUEST[$param.'_ph2'];
      $phone3=$_REQUEST[$param.'_ph3'];
      $phone4=$_REQUEST[$param.'_ph4'];

      return "$phone1-$phone2-$phone3-$phone4";
    } 
    return ($_REQUEST[$param]);    
  }
  // }}}
  // {{{ getNextId()
  /**
   * A shortcut for "SELECT max($id) FROM $table"
   *
   * Known BUG: be carefull when multiple INSERTS at the same table
   *
   * @param string $table Database table name to get the last id
   * @param string $id (Optional) database field  default='id'
   * @return integer the next value to use in the table.
   */
  function  getNextId($table,$id='id') {
    $sql = "SELECT max($id) FROM `$table`";
    $result = $this->database->query($sql);
    if (DB::isError($result)) {
      bif_debug ("error while getting next id <br>\n" .
		 "sql was:<pre>$sql</pre><br>\n" .
		 $result->getMessage());
      die();
    }
    $result = $result->fetchRow();
    return $result[0] + 1;
  }
  // }}}

  // {{{ execQuery()
  /**
   * Execs a given SQL with error handling
   *
   * It's better to exec all SQL querys using 
   * $_SESSION['_BifApplication']->execQuery()
   *
   * @param string $query the Query to exec
   * @return result
   */
  function execQuery($query) {
    // is_a  (PHP 4 >= 4.2.0)   for the future
    if ('' == get_class($this->database)) {
      die("Database not properlly configured. See bifConfig.inc");
    }
    $rst = $this->database->query($query);
    if (DB::isError($rst)) {
      $a=array();
      $a=explode("**",$rst->getDebugInfo());
      die($rst->getMessage() . 
	  "<br>\n<pre>---------[ QUERY ]-----------\n" .
	  array_shift($a) .
	  "\n-----------------------------</pre><br>" .
	  implode("<br>\n",$a));
    } else {
      return $rst;
    }    
  }
  // }}}
}
// }}}
?>
