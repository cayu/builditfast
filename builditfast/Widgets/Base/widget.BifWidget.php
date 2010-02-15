<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 
/**
 * This file holds class BifWidget
 * @package BIF3
 */
// {{{ class BifWidget
/**
 * The main class
 *
 * All widgets should extend this class. It offers
 * representation render thu templates (skins suported)
 * and access control. 
 *
 * @package  BIF3
 * @subpackage Widgets/Base
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.32.2.3 $
 * @tutorial BIF3/CreatingWidgets.pkg
 */

class BifWidget extends PEAR {

  // {{{ properties

  /**
   * Attributes stores the constructor's parameter $attrs
   */
  var $attributes = array();

  /**
   * Substitution in template file.
   * 
   * Ex. if $this->RAWfields=array('TEXT','DATA');
   * template file should have {TEXT} and {DATA} somewhere
   *
   * and what's in  $this->attributes['TEXT'] 
   * and $this->attributes['DATA'] 
   * will do the replace in template
   */
  var $RAWfields = array();

  /**
   * Substitution in template file.
   * 
   * similar to $RAWfields,
   * Ex.
   *
   * $this->attributes['WIDTH']  = "200" ;
   *
   * $this->HTMLfields = array ('WIDTH');
   *
   * the replacement in tpl:
   *
   * {WIDTH}  -> WIDTH="200"
   *
   * else will be empty.
   *
   * Note this is to avoid WIDTH="" which is not HTML complient
   *
   * @see RAWfields
   */
  var $HTMLfields = array();

  /**
   * Widget Name
   *
   * is used to get template file among others thing
   * 
   * If is not specified will be: get_class($this)
   * 
   * NOTE: class name will be in lowercase 
   */
  var $widgetName;

  /**
   * Template
   *
   * BIF3 uses PEAR's Sigma templates, each widget 
   * has it's own template object to render it's representation
   */
  var $tpl;
  
  /**
   * Holds a BifWarning in case of trouble
   *
   * In case there is a problem, 
   *
   * $this->warning=&new BifWarning(array('TEXT'=>'Error 404'))
   * should be used to center all errors in the BifWarning class
   * (for bugreporting for example)
   */
  var $warning;
  // }}}

  function __construct($attrs = array())
    {
      if (! isset($this->widgetName)) {
	$this->widgetName = strtolower(get_class($this)); // asigns the name of the widget. In under case!
      }
      $this->attributes = $attrs;
      // the reference to the application
      parent::PEAR();    // calls PEAR (parent) constructor
    }

  function draw()
    {
      if ($this->hasAccess()) {
	if ($this->isCorrectLang()) {

	  global $app_dir;
	  $this->tpl =& new HTML_Template_Sigma('',$app_dir."/cache/tpl/");

	  // GET template
	  if ($tmp= $_SESSION['_BifApplication']->skin($this->widgetName, '_template')) {
	    $this->tpl->loadTemplatefile($tmp);
	  } else {
	    die("I don't have template file for $this->widgetName\n");
	  }

	  // GET CSS
	  if ($tmp=$_SESSION['_BifApplication']->skin($this->widgetName, '_css')) {
	  addHeadSlot('<link rel="stylesheet" href="' . $tmp . '" type="text/css">');
	  }
	
	  // CALL innerDraw()
	  $this->innerDraw();
	  
	  //check warnings
	  if ($this->warning) {
	    return "<!-- !!WARNING!! $this->widgetName -->\n" . 
	      $this->warning->draw() . 
	      "<!-- END $this->widgetName -->\n";
	  } else {	
	    $this->parseStructures();
	    return $this->tpl->get();
	  }
	} else {
	  return "<!-- WIDGET $this->widgetName wrong lang-->\n";
	}
	
      } else {
	return "<!-- WIDGET $this->widgetName without access -->\n" ;
      }
      
    }

  function show() 
    {
      ob_start('ob_gzhandler');
      echo $this->draw();
    }
  
  function parseStructures()
    {
      // HTMLfields
      // Tienen la propiedad de llamarse igual que un atributo de una entidad
      // HTML por lo tanto se existe se agrega 'ATTR="valor"' si no se
      // busca en el skin que valor existe, sino nada.
      foreach($this->HTMLfields as $field) {
	if ($this->attributes[$field] == "") {
	  if ($tmp=$_SESSION['_BifApplication']->skin($this->widgetName,'_'.$field)) {
	    // Busca en el skin
	    $this->tpl->setVariable($field,"$field=\"$tmp\"");
	  } else {
	    // Nulo
	    $this->tpl->setVariable($field,"");
	  }
	}else{
	  // Parametro pasado por el usuario
	  $this->tpl->setVariable($field,$field.'="'.$this->attributes[$field].'"');
	}
      }    
      //RAWfields
      foreach($this->RAWfields as $field) {
	if ($this->attributes[$field] == "") {
	  if ($tmp=$_SESSION['_BifApplication']->skin($this->widgetName,'_'.$field)) {
	    // Busca en el skin
	    $this->tpl->setVariable($field,$tmp);
	  } else {
	    // Nulo
	    $this->tpl->setVariable($field,"");
	  }
	}else{
	  // Parametro pasado por el usuario
	  $this->tpl->setVariable($field,$this->attributes[$field]);
	}
      }
    }

  function isCorrectLang($lang = '') {
    if ($lang == '') {
      $lang = $_SESSION['_BifApplication']->getVar('lang');
    };

    if (isset($this->attributes['LANG'])) {
      if ($this->attributes['LANG'] != $lang) {
	return FALSE;
      }
    }
      
    return TRUE;
  }

  function hasAccess($question = '') 
    {
      if ((! $question) AND $this->attributes['WIDGETACCESS']) {
	$question=$this->attributes['WIDGETACCESS'];
      } else {
	return true;
      }

      $username  = $_SESSION['_BifApplication']->getVar("user_username");
      $userkeys  = $_SESSION['_BifApplication']->getVar("user_keys");
      $userlevel =  $_SESSION['_BifApplication']->getVar("user_level");

      if (preg_match('/user *= *([a-zA-Z0-9]*)/',$question,$regs)) {
	// there is a user clause!
	if ($regs[1] == $username) {
	  $question = preg_replace('/user *= *'.$regs[1].'/','true',$question);
	} else {
	  $question = preg_replace('/user *= *'.$regs[1].'/','false',$question);
	}
      }
      
      if (preg_match('/keys *= *([a-zA-Z0-9]*)/',$question,$regs)) {
	// there is a keys clause
	if ($userkeys) {
	  if(preg_match('/['.$userkeys.']/',$regs[1])) {
	    $question = preg_replace('/keys *= *'.$regs[1].'/','true',$question);
	  } else {
	    $question = preg_replace('/keys *= *'.$regs[1].'/','false',$question);
	  }
	} else {
	  $question = preg_replace('/keys *= *[a-zA-Z0-9]*/','false',$question);
	}

      }

      if (preg_match('/level( *[<>!=]* *[0-9]*)/',$question,$regs)) {
	// there is a level clause
	  $question = preg_replace('/level *[<>!=]* *[0-9]*/',$userlevel.$regs[1],$question);
      }      

      return eval("return $question;");
    }

  function __destruct()
    {
      // Destructor
    }
  
  function &getWidget($name)
    {
      if ($this->attributes['BIFID']==$name) {
	return($this);
      }
      return($a=FALSE);
    }
  // DUMB innerDraw
  
  function innerDraw()
    {
    }
}
?>
