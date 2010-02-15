<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds the FTDateTime class
 * @package BIF3
 */

/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/FT/FTItem.php");

// {{{ class FTDateTime
/**
 * Implements a specialized widget as FTDate, but with Time included.
 *
 * @package    BIF3
 * @subpackage Widgets/FT
 * @author     Nicolás D. César <ncesar@lunix.com.ar>
 * @version    $Revision: 1.5.6.3 $
 * @see        FTDate
 * @see        FTItem
 */
class FTDateTime extends FTItem {
  // {{{ function FTDateTime
  /**
   * Instantiate a FTDateTime widget.
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
   * @parameter string HORA hour.
   * @parameter string MIN minutes.
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
      $ahora['hours'] = $this->attributes['HORA'];
      $ahora['minutes'] = $this->attributes['MIN'];
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
    $this->item->addChild(new BifText(array('TEXT' => '   ')));
    $this->item->addChild(new FormText(array(
					     'NAME' =>  $this->attributes['NAME']. '_hora', 
					     'VALUE' => $ahora['hours'] ,
					     'SIZE' => '2', 
					     'MAXLENGTH' => '2',
					     )
				       )
			  );
    $this->item->addChild(new BifText(array('TEXT' => ':')));
    $this->item->addChild(new FormText(array(
					     'NAME' =>  $this->attributes['NAME']. '_min', 
					     'VALUE' => $ahora['minutes'] ,
					     'SIZE' => '2', 
					     'MAXLENGTH' => '2',
					     )
				       )
			  );
    $this->item->addChild(new BifText(array('TEXT' => 'hs.')));
    
    
  } // }}}
} // }}}

?>
