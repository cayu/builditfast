<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

class Component {
// should extend BifWidget... BUUUT.. Bif widget holds application var
// and when session is recovered, it makes a infinite loop and memory cosumition!
  var $logicalId;
  var $actualView; 

  var $alfanumParam = array();
  var $alfaParam = array();
  var $numParam = array();
  var $nullalfanumParam = array();
  var $nullalfaParam = array();
  var $nullnumParam = array();
  var $parameters = array();
  var $errors = array();

  var $observers = array();

  function __construct($logicalId,$attr = array())
    {
      $this->logicalId  =$logicalId;
      $this->attributes =$attr; 
    }

  // dummy publicInit() -- should be redefined in child class
  function publicInit()
    {
      $this->actualView = 'publicInit() method in '.get_class($this).' not defined yet!';
    }

  function draw() 
    {
      return  $this->actualView;
    }

  function callMethod($method,$params)
    {
      if ( method_exists($this,'public'.$method) ){
	//just call it
	return (call_user_func_array(array (&$this,'public'.$method),&$params));
      }else{
	bif_debug ("Public Method $method doesn't exists\n");
	die();
      }
    }

  
  // Asigna los parametros sacados de 'getparameters' a una variable de la instancia
  // util para agilizar la creacion de  Componentes

  function processParameters() {
    $this->parameters = array_merge($this->alfanumParam,$this->alfaParam, $this->numParam,$this->nullalfanumParam,$this->nullalfaParam, $this->nullnumParam,$this->parameters);
    $tmp=array();
    if (is_array($this->parameters)) {
      foreach ($this->parameters as $param) {
	$this->$param = $_SESSION['_BifApplication']->getParameter($param);
	$tmp[$param] = $_SESSION['_BifApplication']->getParameter($param);
      } 
    } 
    return $tmp;
  }

  function verification() {
    $incorrecto = 'Incorrecto';
    $this->errors = array();

  foreach ($this->alfanumParam as $param) {
    if (check_alfanum($this->$param)) {	 
      unset($this->errors[$param]);
    } else {
      $this->errors[$param] = $incorrecto;
    }
  }

  foreach ($this->alfaParam as $param) {
    if (check_alfa($this->$param)) {
      unset($this->errors[$param]);
    } else {
      $this->errors[$param] = $incorrecto;
    }
  }

  foreach ($this->numParam as $param) {
    if (check_num($this->$param)) {
      unset($this->errors[$param]);
    } else {
      $this->errors[$param] = $incorrecto;
    }
  }

  foreach ($this->nullalfanumParam as $param) {
    if (check_alfanum($this->$param) || $this->$param=='') {
      unset($this->errors[$param]);
    } else {
      $this->errors[$param] = $incorrecto;
    }
  }

  foreach ($this->nullalfaParam as $param) {
    if (check_alfa($this->$param) ||$this->$param=='') {
      unset($this->errors[$param]);
    } else {
      $this->errors[$param] = $incorrecto;
    }
  }

  foreach ($this->nullnumParam as $param) {
    if (check_num($this->$param)||$this->$param=='') {
      unset($this->errors[$param]);
    } else {
      $this->errors[$param] = $incorrecto;
    }
  }
  
  }

 
  function getHooks(){}
  function getStubs(){}
  function sendObservers($idStub,$params = array()){
    // REPORTAR ERROR  $obs->stub$idStub () no existe...  o similar
    if (is_array($this->observers[$idStub])) {
      foreach (array_keys($this->observers[$idStub]) as $obs) {
	call_user_func_array(array (&$_SESSION['_BifApplication']->components[$obs],'stub'.$idStub),&$params);

      }
    }
  }

  function addObserver($observerLogicalId,$idStub){
    $this->observers[$idStub][$observerLogicalId] = 1;
  }

  function removeObserver($observerLogicalId,$idStub){
    unset($this->observers[$idStub][$observerLogicalId]);
  }

  function removeObserverFromAllStubs($observerLogicalId,$idStub) {}

}

?>