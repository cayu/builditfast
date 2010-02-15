<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class TitlePara
 * @package  BIF3
 */
// {{{ class TitlePara
/**
 * Containains paragraph with a title.
 *
 * TitlePara is used for 'skineable' paragraphs with text.
 * Usually holds BifRawTexts or similar.
 * 
 * @package  BIF3
 * @subpackage Widgets/Text
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.4.26.3 $
 */

class TitlePara extends BifContainer {

  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string TITLE title
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);
  }

  function preChilds(){
    $this->RAWVars=array('TITLE');
  }

}

?>