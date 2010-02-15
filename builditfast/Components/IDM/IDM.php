<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/* Descripción de los campos... 

* unico nombre: variable_php <--> Base de datos
* contemplar  fecha. 
* validación 
* transformación.
*/

/* Dato(s) del user -> pre_formato -> validación -> transformación -> insert */

class IDM extends Component{ 
  /* var: form_file
   * file.bif to use as a form
   * if empty:
   * Automatically generates IDM.bif based on BIFtype
   */
  var $form_file = ''; 
  var $form_file_modify = '';   
  var $form_file_modify_view = '';   
  /* var: table 
   * the used table
   */
  var $table = '';
  /* var: fields
   * 
   * description of fields to use in database. 
   * TODO: read fields from .xml file
   * TODO: later parse database and generate all .xml files :-)
   */
  var $fields = array(
		      //   array('name','SQLtype','BIFtype','BIFextraparams','validacion','transform'),
		      );
  /* var: values 
   * collected values
   */
  var $values = array(); 
  /* var: insert
   * due to transformation problems... need another array
   */
  var $insert = array(); 

  /* var: errors
   * array with posible errors during verification
   */
  var $errors = array(); 
  /* var: incorrect
   * string to fill incorrect values.
   */
  var $incorrect = "Incorrecto";

  /* var set_fixed
   * array that includes the fixed values to be set in the insert
   * example: 
   * $set_fixed=array('`habilitado` = \'1\'',
                      '`deleted`    = \'0\'');
  */
  var $setFixed = array(); 

  /*
   * Fixed values when delete is made.
   */
  var $setDelete = array();


  /* var: replaceFixed
   * values to be replaced in .bif
   */

  var $replaceFixed = array();


  /* var: update
   * list of signals to send after insert
   */

  var $update = array();

  /* var: render_string
   * form with contents of file or automatically generated 
   */
  var $render_string = '';

  /* var: importantFields
   * fields' list. Will be used to confirm deletion.
   * example:
   * var  $importantFields = array('id','Name','Lastname');
   */
  var $importantFields = array();

  /* var: var $primaryKey
   * key fields' list, Will be used to get element to modify.
   */
  var $primaryKey = array();

  /* var: $active
   * active field (it will be changed to  $this->zero instead of being deleted)
   * ej: 
   *   var $active = 'habilitado';
   */
  var $active = '';
  var $zero = '0';

  /* var $SQLRender
   * A render class name.
   */

  var $SQLRender = '';

  /* var $_message
   * a PRIVATE var that holds current message
   */
  var $_message = '';

  /* var $_specialBIFTypes
   * an array of containers names (IN LOWER CASE!!)
   * because can't include '"' and '<' and '>' in values
   * its a work arroud for FTTextArea among others
   */

  var $_specialBIFTypes = array('fttextarea');

  function __construct($id,$attrs){
    parent::__construct($id,$attrs);
  }

  function publicInit() {
    $this->publicClear();

    // Get info about tables in the database
    $tablesql = $_SESSION['_BifApplication']->database->getSpecialQuery('tables');
    if (!$tablesql) {      
      bif_debug("Cant get list of tables for this database. Not creating table $this->table.");
    };
    // get all tables in array $arr
    $arr = $_SESSION['_BifApplication']->database->getListOf('tables');
    // if it's not there, then create it!
    if (! in_array($this->table,$arr)) {
      bif_debug("Creating table $this->table.");
      $fields = array();
      foreach ($this->fields as $a) {
	array_push($fields, "`" . $a[0] . "` " . $a[1] );
      };
      
      $sql = "CREATE TABLE `$this->table` ( \n " .
	implode(",\n",$fields) .
	" ,  `$this->active` tinyint(1) NOT NULL default '1', \n " .
	"  PRIMARY KEY  (`".$this->primaryKey[0]."`) " .
	")";
      
      $_SESSION['_BifApplication']->execQuery($sql) ;
    }

    switch($this->attributes[0]) {
    case 'delete':
      $this->setSearchView();
      break;
    case 'modify':
      $this->setSearchView();
      break;
    case 'insert':
      $this->setInsertView();
      break;

    default:
      die("First parameter of $this->logicalId should be 'insert', 'delete' or 'modify'");
      break;
    }
  }

  function setInsertView() {
    if ($this->form_file != '' ) {
      if (!($fp = fopen($this->form_file, 'r'))){
	die("FATAL ERROR: Can't open file <b>$this->form_file</b> for reading.");
      }  
      $this->render_string = fread($fp,filesize($this->form_file) );
      fclose($fp);
    } else { 
      $tabla = ucfirst($this->table);
      $this->render_string=
	"<TitleBox title=\"Alta - $tabla\">     \n".
	"<Font size=\"+2\">{MENSAJE}</Font>     \n".
	"<FT METHOD=\"POST\">                   \n".
	"<FormHidden name=\"action\" value=\"$this->logicalId.Insert\" />\n";
      foreach ($this->fields as $subarray) {
	list($name,$SQLtype,$BIFtype,$BIFparams,$validate,$transform) = $subarray;
        if (in_array(strtolower($BIFtype),$this->_specialBIFTypes) ){
	  // Work arround for FTTextArea for example...
	  $this->render_string.=
	    "<$BIFtype name=\"$name\" error=\"\{error_$name}\" ".
	    "$BIFparams>\{$name}</$BIFtype>                  \n";
	} else {
	  $this->render_string.=
	    "<$BIFtype name=\"$name\" value=\"\{$name}\" ".
	    "error=\"\{error_$name}\"  $BIFparams />   \n";
	}
      }
      $this->render_string .= "<FTSubmit value=\"Siguiente ->\" /></FT></TitleBox>";
    }
    $init =& render($this->render_string,array('ACTION'=>$this->logicalId . '.Insert',
					       'MENSAJE'=>$this->_message
					       ) );
    $this->actualView =  $init->draw();
  }

  function setSearchView() {
    if ($this->form_file != '' ) {
      if (!($fp = fopen($this->form_file_modify, 'r'))){
	$this->actualView = "FATAL ERROR: Can't open file <b>$this->form_file</b> for reading.";
	return;
      }  
      $this->render_string = fread($fp,filesize($this->form_file_modify) );
      fclose($fp);
    } else { 
      $tabla = ucfirst($this->table);
      $this->render_string  = 
	"<TitleBox title=\"Modificar y borrar - $tabla\">                \n" .
	"<Font size=\"+2\">{MENSAJE}</Font>                              \n" .
	"<FT method=\"POST\">                                            \n" .
	"<FormHidden name=\"action\" value=\"{ACTION}\" AT=\"OUTSIDE\" />\n" .
	"<FTText name=\"search\" description=\"$this->searchField: \" /> \n" .
	"<FTSubmit value=\"Buscar\" />                                   \n" .
	"</FT>{SQL}                                                      \n" .
        "</TitleBox>";
    }
    $replace = array_merge($row,
			   $this->replaceFixed,
			   array('ACTION'=>$this->logicalId . '.Search',
				 'MENSAJE'=>$this->_message
				 ));
    $init    = render($this->render_string,$replace);
    $this->actualView =  $init->draw();
    $this->_message = "";
  }

  function publicSearch(){
    // search value
    $search=$_SESSION['_BifApplication']->getParameter('search');

    $query = "SELECT " .
      implode(', ',$this->importantFields) . 
      ", 'Modificar', 'Borrar' FROM `$this->table`" .
      " WHERE `$this->searchField` like '$search%' AND `$this->active` != $this->zero".
      " ORDER BY '$this->searchField'";

    $sql =& new MySQLTable(array('QUERY'=> $query,
				 // Pensar como hacer el render
				 'RENDER' => $this->SQLRender,
				 // 'HIDDEN' => "...",
				 ));

    $init =& render($this->render_string,
		    array('SQL' => $sql->draw(),
			  'SEARCHFIELD' => $this->searchField,
			  'ACTION'=>$this->logicalId . '.Search',
			  'MENSAJE'=>$this->_message
			  )); 
    $this->actualView = $init->draw();
  }

  function publicModifyView() {
    /******
     * Get from file or  create FORM
     */
    if ($this->form_file != '' ) {
      if (!($fp = fopen($this->form_file_modify_view, 'r'))){
	$this->actualView = "FATAL ERROR: Can't open file ".
	  "<b>$this->form_file</b> for reading.";
	return;
      }  
      $this->render_string = fread($fp,filesize($this->form_file_modify_view) );
      fclose($fp);
    } else {
      
      $self=$_SERVER['PHP_SELF'];

      $this->render_string=
	"<TitleBox title=\"Modificar elemento\">".
	"<FT action=\"$self\" method=\"POST\">" . 
	'<FormHidden name="action" value="'.
	$this->logicalId. '.Modify" />';
      foreach ($this->fields as $subarray) {
	list($name,$SQLtype,$BIFtype,$BIFparams,
	     $validate,$transform) = $subarray;

        if (in_array(strtolower($BIFtype),$this->_specialBIFTypes) ){
	  // Work arround for FTTextArea for example...
	  $this->render_string.="<$BIFtype name=\"$name\" error=\"\{error_$name}\" ".
                                " $BIFparams>\{$name}</$BIFtype>\n";
        } else {
	  $this->render_string.="<$BIFtype name=\"$name\" value=\"\{$name}\" " . 
	                        "error=\"\{error_$name}\"  $BIFparams />\n";
        }
      }
      $this->render_string .= 
	"<ftsubmit value=\"Modificar\"/>{HIDDENS}</FT>" .
	"<FT action=\"$self\" method=\"POST\">" .
	"<FormHidden name=\"action\" value=\"" . $this->logicalId . ".Init\" />" .
	"<FTSubmit value=\"Cancelar\"/></FT>" .
	"<Font size=\"+2\">{MENSAJE}</Font></TitleBox>";
    } // $this->render_string created


    if ( sizeof($this->errors) == 0 ) {
      /** In case we dont have errors
       * do a SELECT with database.
       */
      foreach($this->primaryKey as $pk) {
	$$pk = $_SESSION['_BifApplication']->getParameter($pk);      
	if (! $$pk) {
	  $w = new  BifWarning(array('TEXT'=>
				     "ERROR Need primary key `$pk` ".
				     "at component $this->logicalId"));
	  $this->actualView = $w->draw();
	  return;
	}
	$where = array();
	array_push($where," `$pk` = '${$pk}'");
      }
      
      $query = "SELECT * ".
	" FROM `$this->table`".
	" WHERE ".implode(" AND ",$where);
      $result = $_SESSION['_BifApplication']->execQuery($query) ;
      $row = $result->fetchRow(DB_FETCHMODE_ASSOC);    
      
      // set primary key as hidden fields     
      $hiddens="";
      foreach ($this->primaryKey as $key) {
	// FIXME: should use FTHidden widget 
	$hiddens.="<formhidden name=\"$key\" value=\"".$row[$key]."\"  AT=\"OUTSIDE\" />";
      }
      
      // Elimino quienes no tienen que ser 
      // representados de nuevo en la modificacion.
      foreach ($this->fields as $subarray) {
	list($name,$SQLtype,$BIFtype,$BIFparams,$validate,$transform,$represent) = $subarray;
	if (isset($represent) && $represent == false) {
	  unset($row["$name"]);
	}
      } 
      $this->values = $row;
    }

    $replace=array_merge($this->values,
			 $this->replaceFixed,		 
			 array('error_'=>$this->errors,
			       'ACTION'=>$this->logicalId . '.Modify',
			       'CANCEL'=>$this->logicalId . '.Init',
			       'MENSAJE'=>$this->_message,
			       'HIDDENS'=>$hiddens));
    $init =& render($this->render_string,$replace);
    $this->actualView =  $init->draw();
  }

  function publicDelete() {
    if (sizeof($this->errors) == 0) {

      $set = $this->setFixed;
      $setDelete = $this->setDelete;
      $set = array_merge($set,$setDelete);
      array_push($set,"`$this->active` = '$this->zero'");
   
      foreach($this->insert as $name => $val) {
	if (! in_array($name, $this->primaryKey) ) {
	  array_push($set,"`$name` =  '$val'");
	}
      }

      foreach($this->primaryKey as $pk) {
	$$pk = $_SESSION['_BifApplication']->getParameter($pk);
	  
	if (! $$pk) {
	  $w = new  BifWarning(array('TEXT'=> "ERROR Need primary key `$pk`".
				     " at component $this->logicalId"));
	  $this->actualView = $w->draw();
	  return;
	}
	  
	$where = array();
	array_push($where," `$pk` = '${$pk}'");
      }

      $query=
	"UPDATE `$this->table` ".
	" SET "  . implode(' , ',$set) .
	" WHERE ". implode(' AND ',$where);
      
      $_SESSION['_BifApplication']->execQuery($query);      
      $this->afterDelete();
      foreach ($this->update as $update) {
	$this->sendObservers($update);
      }

      if (is_array($this->importantFields) AND
	  sizeof($this->importantFields) >  0) {
	$tmp = array();
	foreach ($this->importantFields as $key) {
	  array_push($tmp,$this->values[$key]);
	}
	$this->_message="'". implode(', ',$tmp)  ."' eliminado.";
      } else {
	$this->_message = "Eliminado.";
      }
    } 
    $this->publicInit();
  }

  function publicClear() {
    // clears internal vars
    $this->values= array();
    $this->errors= array();
    $this->_message = "";
  }

  function postprocessFields() 
    { 
      return true;
    }

  function postInsertSuccess() 
    { 
      return true;
    }


  function processFields($type = 'insert') {
    $this->errors= array();
    foreach ($this->fields as $subarray) {
      list($name,$SQLtype,$BIFtype,$BIFparams,$validate,$transform,$ins) = $subarray;

      $value = $_SESSION['_BifApplication']->getParameter($name);

      if ($validate) {
	if (!$validate($value,$type)) {
	  $this->errors[$name] = $this->incorrect;
	}
      } else {
	unset($this->errors[$name]);
      }
      $this->values[$name] = $value;
      if ($transform) {
	$value = $transform($value);
      }

      /*      if ($name=='Archivo') {
	bif_debug($subarray,2);
	echo "--";
	die();
      }
      */

      if (($value == '') OR $ins) { //TODO: document $ins and it's importance
	$this->insert[$name] = $value;
      } else {
	bif_debug("unsetting $name in ". $this->logicalId,2);
	unset($this->insert[$name]);
      }
    };
  }

  function publicInsert() {
    $this->processFields('insert');

    if (sizeof($this->errors) == 0 &&  $this->postprocessFields('insert')) {
      $set = $this->setFixed;
      foreach($this->insert as $name => $val) {
	array_push($set,"`$name` =  '$val'");
      }

      $query="INSERT INTO `$this->table` SET " . implode(' , ',$set)  ;
      bif_debug($query,3);

      $_SESSION['_BifApplication']->execQuery($query);
      $this->last_id = 
	$_SESSION['_BifApplication']->getNextId
	($this->table,$this->primaryKey[0]) - 1;
      foreach ($this->update as $update) {
	$this->sendObservers($update);
      }
	

      if (is_array($this->importantFields)       AND
	  sizeof($this->importantFields) >  0) {
	$tmp = array();
	foreach ($this->importantFields as $key) {
	  array_push($tmp,$this->values[$key]);
	}

	$this->_message = "'". implode_non_empty(', ',$tmp)  ."' agregado.";
      } else {
	$this->_message = "Agregado.";
      }
      $this->afterInsert();
      $this->postInsertSuccess(); // deprecated shoul use 'afterInsert'
      $this->values= array();
      $this->errors= array();
    } else {
      if (sizeof($this->errors) != 0) {
	$this->_message="Hay errores en: " .
	  implode(', ',array_keys($this->errors));
      }
    }

    $replace=array_merge($this->values,
			 $this->replaceFixed,
			 array('error_'=>$this->errors,
			       'MENSAJE'=> $this->_message,
			       'ACTION'=>$this->logicalId . '.Insert')); 
    $view = render($this->render_string,$replace);
    $this->actualView =   $view->draw();
  }

  function publicModify()     {
    $this->processFields('modify');

    if (sizeof($this->errors) != 0 ){
      $this->publicModifyView();
      return;
    } 

    if (sizeof($this->errors) == 0 &&  $this->postprocessFields('insert')) {
      // Create SQL 'SET'
      $set = $this->setFixed;
      foreach($this->insert as $name => $val) {
	if (! in_array($name, $this->primaryKey) ) {
	  array_push($set,"`$name` =  '$val'");
	}
      } // constructed SET
      
      // Create SQL 'WHERE'
      foreach($this->primaryKey as $pk) {
	$$pk = $_SESSION['_BifApplication']->getParameter($pk);
	if (! $$pk) {
	  $w = new  BifWarning(array('TEXT'=>"ERROR Need primary key `$pk` at component $this->logicalId"));
	  $this->actualView = $w->draw();
	  return;
	}      
	$where = array();
	array_push($where," `$pk` = '${$pk}'");
      } // constructed WHERE
      
      $query=
	"UPDATE `$this->table` " .
	"SET " . implode(' , ',$set) . " " .
	"WHERE". implode(' AND ',$where);
      
      // Execute query
      $_SESSION['_BifApplication']->execQuery($query);
      $this->afterModify();
      foreach ($this->update as $update) {
	$this->sendObservers($update);
      }
      
      // 'Modified' message
      if (is_array($this->importantFields) AND
	  sizeof($this->importantFields) >  0) {
	$tmp = array();
	foreach ($this->importantFields as $key) {
	  array_push($tmp,$this->values[$key]);
	}
	$this->_message="'". implode(', ',$tmp)  ."' modificado.";
      } else {
	$this->_message = "Modificado.";
      }
    }

    // clear the form 
    // so the user doesn't get confused
    $this->publicClear();
    $this->publicInit();
  }

 function afterInsert()  {
   }
 function afterModify()   {
   }
 function afterDelete()   {
   }
}

function non_empty($str) {
  return ($str != "");
}

function implode_non_empty($str,$arr) {
  $arr = array_filter($arr,"non_empty");
  return implode($str,$arr);
}
?>
