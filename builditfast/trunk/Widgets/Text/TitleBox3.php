<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class TitleBox3
 * @package  BIF3
 */
// {{{ class TitleBox3
/**
 * A box with a defined title.
 *
 * TitleBox is used for design propouse.
 * Usually holds BifRawTexts or similar.
 * There are different TitleBoxes for design propuse
 * 
 * @package  BIF3
 * @subpackage Widgets/Text
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.4.26.3 $
 */

class TitleBox3 extends BifContainer {

  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string TITLE title
   * @parameter string WIDTH table's fixed width
   * @parameter string ALIGN table's align
   * @parameter string CELLPADDING Cell padding
   * @parameter string CELLSPACING Cell spacing
   * @parameter string BORDER border
   * @parameter string BGCOLOR background collor
   */
  function __construct($attrs = array()) 
    {
      parent::__construct($attrs);
    }

  function preChilds() 
    {
      $this->HTMLfields = array('WIDTH','ALIGN','CELLPADDING','CELLSPACING','BORDER','BGCOLOR');
      $this->RAWfields= array('TITLE');
    }
}
?>