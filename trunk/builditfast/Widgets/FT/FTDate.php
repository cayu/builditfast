<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds the FTDate class
 * @package BIF3
 */

/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/FT/FTItem.php");

// {{{ class FTDate
/**
 * Implements several widgets to assemble a date specialized widget as FTItem.
 *
 * FTDate is specially designed to be used as a date input widget, it doesn't
 * make any type of data control.
 * NOTE: You can use the Application::getParameter() method like this:
 * $bigint =  $_SESSION['_BifApplication']->getParamenter('dateMyVar');
 * $bigint will contain a 14 digit number that's the timestamp of MyVar,
 * special to be used on a database.
 *
 * @package    BIF3
 * @subpackage Widgets/FT
 * @author     Nicolás D. César <ncesar@lunix.com.ar>
 * @version    $Revision: 1.11.6.3 $
 * @see        FTItem
 * @see        FormText
 */
class FTDate extends FTItem {
  // {{{ function FTDate
  /** 
   * Instantiate a FTDate widget.
   *
   * This constructor inherits attributes from FTItem: DESCRIPTION,
   * ITEM, HELP and ERROR.
   *
   * @parameter $attrs Instance's attributes specified as a hash in CAPS.
   * @parameter string NAME Variable's name.
   * @parameter string VALUE Timestamp for defalt value.
   * @parameter string DIA Day number.
   * @parameter string MES Month number.
   * @parameter string ANO Year number.
   */
  function __construct($attrs = array()) {
    $this->widgetName="ftitem";
    parent::__construct($attrs);

    if (isset($this->attributes['VALUE'])) {
      if (is_numeric($this->attributes['VALUE']) && $this->attributes['VALUE'] != -1) {
	$ahora = getdate($this->attributes['VALUE']); 
      } else {
	$ahora = getdate();
      }
    } else {
      $ahora['mday'] =  $this->attributes['DIA'];
      $ahora['mon']  =  $this->attributes['MES'];
      $ahora['year'] =  $this->attributes['ANO'];
    }
      

    $this->item =& new RowCnt;

    $this->item->addChild(new FormText(array(
					     'NAME' =>  $this->attributes['NAME']. '_dia', 
					     'VALUE' => $ahora['mday'] ,
					     'SIZE' => '2', 
					     'MAXLENGTH' => '2',
					     )
				       )
			  );
    $this->item->addChild(new BifText(array('TEXT' => ' - ')));
    $this->item->addChild(new FormText(array(
					     'NAME' =>  $this->attributes['NAME']. '_mes', 
					     'VALUE' => $ahora['mon'] ,
					     'SIZE' => '2', 
					     'MAXLENGTH' => '2',
					     )
				       )
			  );
    $this->item->addChild(new BifText(array('TEXT' => ' - ')));
    $this->item->addChild(new FormText(array(
					     'NAME' =>  $this->attributes['NAME']. '_ano', 
					     'VALUE' => $ahora['year'] ,
					     'SIZE' => '4', 
					     'MAXLENGTH' => '4',
					     )
				       )
			  );
    
    
  } // }}}
} // }}}

?>
