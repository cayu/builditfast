<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 
/**
 * This file holds class HTMLTag
 * @package  BIF3
 */

/**
 * some globals definitions render() also needs them
 */
$GLOBALS['HTMLBlock_Tags'] = array('TABLE','TBODY','TH','TR','TD', 'FORM', 'DIV','B','I','STRIKE','A','P','PRE','OL','UL','TT','SPAN','FONT','H1','H2','H3','H4','U','STRONG','SUB','CENTER','IFRAME','FRAME','FRAMESET','NOFRAMES','STYLE','SCRIPT','EM','MAP','AREA');
$GLOBALS['HTMLOpen_Tags'] = array('IMG','BR','LI','INPUT','HR','LINK');
$GLOBALS['HTMLVALs'] = array_merge($GLOBALS['HTMLBlock_Tags'] , 
				   $GLOBALS['HTMLOpen_Tags']);

// {{{ class HTMLTag
/**
 * Special class ment to use in render so we can include XHTML in .bif files.
 * 
 * @package  BIF3
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.19.8.4 $
 * @parameter string TAG HTML tag (Ex. 'TABLE', 'B', 'FONT', 'IMG')
 * @parameter string other attributes: will be parsed as HTML attributes for the tag
*/
class HTMLTag extends BifContainer 
{
  function __construct($attrs = array()) 
    {
      parent::__construct($attrs);
    }

  function preChilds() 
    {
      $GLOBALS['HTMLTag_att'] = "";
      array_walk($this->attributes, 'HTMLTag_convert_att');
      $this->attributes['ATT']=$GLOBALS['HTMLTag_att'];
      
      if (in_array($this->attributes['TAG'], $GLOBALS['HTMLOpen_Tags'])) {
	$this->attributes['TAGEND'] = "";
      } else {
	$this->attributes['TAGEND'] = '</' . $this->attributes['TAG'] . '>'; 
      }
      $this->RAWfields=array('TAG','ATT','TAGEND'); 
    }
}
// }}}

function HTMLTag_convert_att($valor, $clave)
{
  if ("$clave" != 'TAG') {
    $GLOBALS['HTMLTag_att'] .= $clave . '="' . $valor. '" ';
  }
}

?>