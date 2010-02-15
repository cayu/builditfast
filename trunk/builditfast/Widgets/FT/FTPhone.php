<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/**
 * This file holds the FTPhone class
 * @package BIF3
 */

/**
 * Required files
 */
global $sys_dir;
require_once("$sys_dir/Widgets/FT/FTItem.php");

// {{{ class FTPhone
/**
 * Implements a phone entry widget ready to use as a FTItem.
 *
 * @package    BIF3
 * @subpackage Widgets/FT
 * @author     Nicolás D. César <ncesar@lunix.com.ar>
 * @version    $Revision: 1.7.6.3 $
 * @see        FTItem
 */
class FTPhone extends FTItem {
  /** {{{ function FTPhone
   *
   * Instantiate a FTPhone widget.
   *
   * This constructor inherits attributes from FTItem: DESCRIPTION,
   * ITEM, HELP and ERROR.
   *
   * @parameter $attrs Instance's attributes specified as a hash in CAPS.
   * @parameter string NAME Variable's name.
   * @parameter string VALUE1 country code.
   * @parameter string VALUE2 state/province/region code.
   * @parameter string VALUE3 phone number.
   * @parameter string VALUE4 intern number.
   * @parameter string VALUE Data assembled like this: VALUE1-VALUE2-VALUE3-VALUE4
   */
  function __construct($attrs = array()) {
    $this->widgetName="ftitem";
    parent::__construct($attrs);

    if ($this->attributes['VALUE']) {
      $tmp = explode("-",$this->attributes['VALUE']);
      $this->attributes['VALUE1'] = $tmp[0];
      $this->attributes['VALUE2'] = $tmp[1];
      $this->attributes['VALUE3'] = $tmp[2];
      $this->attributes['VALUE4'] = $tmp[3];
    }

    $this->item =& new RowCnt;    
    $this->item->addChild(new FormText(array(
					     'NAME' =>  $this->attributes['NAME']. '_ph1', 
					     'VALUE' => $this->attributes['VALUE1'],
					     'SIZE' => '3', 
					     'MAXLENGTH' => '3',
					     )
				       )
			  );
    $this->item->addChild(new BifText(array('TEXT' => ' - ')));
    $this->item->addChild(new FormText(array(
					     'NAME' =>  $this->attributes['NAME']. '_ph2', 
					     'VALUE' => $this->attributes['VALUE2'],
					     'SIZE' => '5', 
					     'MAXLENGTH' => '5',
					     )
				       )
			  );
    $this->item->addChild(new BifText(array('TEXT' => ' - ')));
    $this->item->addChild(new FormText(array(
					     'NAME' =>  $this->attributes['NAME']. '_ph3', 
					     'VALUE' => $this->attributes['VALUE3'],
					     'SIZE' => '16', 
					     'MAXLENGTH' => '16',
					     )
				       )
			  );
    $this->item->addChild(new BifText(array('TEXT' => ' int: ')));
    $this->item->addChild(new FormText(array(
					     'NAME' =>  $this->attributes['NAME']. '_ph4', 
					     'VALUE' => $this->attributes['VALUE4'],
					     'SIZE' => '4', 
					     'MAXLENGTH' => '4',
					     )
				       )
			  );
  } // }}}
} // }}}

?>
