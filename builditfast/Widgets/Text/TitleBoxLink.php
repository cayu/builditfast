<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class TitleBoxLink
 * @package  BIF3
 */
// {{{ class TitleBoxLink
/**
 * A box with a defined title and a link.
 *
 * TitleBoxLink is used for design propouse.
 * similar to TitleBox
 * 
 * @package  BIF3
 * @subpackage Widgets/Text
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.6.26.3 $
 */

class TitleBoxLink extends BifContainer {

  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string TITLE title
   * @parameter string TEXT link's text
   * @parameter string HREF link's href
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
      if (! $this->attributes['BORDER'] ) {
	$this->attributes['BORDER']='0';
      }

      if (! $this->attributes['CELLPADDING'] ) {
	$this->attributes['CELLPADDING']='0';
      }

      if (! $this->attributes['CELLSPACING'] ) {
            $this->attributes['CELLSPACING']='0';
         }
     if (! $this->attributes['BGCOLOR'] ) {
	$this->attributes['BGCOLOR']='#EEEEEE';
      }

      $this->HTMLfields = array('WIDTH','ALIGN','CELLPADDING','CELLSPACING','BORDER','BGCOLOR' ,'HREF');
      $this->RAWfields= array('TITLE','TEXT');
    }
}
?>