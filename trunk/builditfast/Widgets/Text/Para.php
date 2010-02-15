<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds class TitleBox
 * @package  BIF3
 */
// {{{ class TitleBox
/**
 * Containains paragraphs usually holds BifRawTexts or similar.
 *
 * Usually is a html P tag.  
 *
 * TODO: in a medium future, it could hold comments, just
 * as slashdot's articles' comments
 * 
 * @package  BIF3
 * @subpackage Widgets/Text
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.5.26.3 $
 */

class Para extends BifContainer {

  function __construct($attrs = array()) {
    parent::__construct($attrs);
  }

}

?>