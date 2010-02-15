<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 


/**
 * This file holds class BifInclude
 * @package  BIF3
 */

/**
 * Required files
 */
global $sys_dir;
include_once("$sys_dir/Widgets/Contrib/Snoopy.php");
include_once("$sys_dir/Widgets/Basic/BifRawText.php");

// {{{ class BifInclude
/**
 * A widget container thats include the HTML/BIF file
 * 
 * This Widgets uses Snoopy class to get several types of documents, and show them.
 * Examples: 'exec://' (executes a program), 'component://' (loads a component),
 * '*doc' (Show a MS .doc file with wvHtml), 'http://' or 'ftp://' (gets a file),
 * '*html'  (shows an html) '*bif' renders a bif file
 * 
 * @package  BIF3
 * @subpackage Widgets/Basic
 * @author   Nicolas Cesar <ncesar@lunix.com.ar>
 * @version  $Revision: 1.16.6.3 $
*/
class BifInclude extends BifContainer {
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string SRC: an be a path or a URL. Must be compete (http://...)
   */
  function __construct($attrs = array()) 
    {
      parent::__construct($attrs);
    }
  
  function preChilds()
    {
      $file = $this->attributes['SRC'];
      if($file == "") {
	$this->warning =  &new BifWarning(array('TEXT' => 'SRC attribute not specified.'));

	// Exec a command.
      }else if(eregi('exec://(.*)',$file,$regs)){
	// whatch out with browser's STOP
	ignore_user_abort(true);
	$bif_code=`$reg[1]`;
	$included=&render($bif_code);
	$this->addChild($included);

	// COMPONENT with logicalID $idlogico
      }else if(eregi('component://(.*)',$file,$regs)){
	$logicalId=$regs[1];
	$this->addChild($_SESSION['_BifApplication']->getComponent($logicalId));      

	// MS .doc file
      } else if (eregi('doc$',$file)) { 
	$html=`wvHtml --charset=ISO_8859-1 --targetdir=/tmp $file -`;
	if ($html) {
	  $this->addChild(new BifRawText(array('TEXT' => $this->_clean($html))));
	}

	// BIF FILES 
      } else if (eregi('bif$',$file)) { 
	$included=&render(file_get_contents($file));
	$this->addChild($included);

	// Snoopy guesser
      } else if(eregi('(.*)://(.*)',$file)){
	$snoopy =& new Snoopy;
	$snoopy->fetch($file);
	$included=&new BifRawText(array('TEXT' => $snoopy->results));
	$this->addChild($included);

	// file is missing
      }else if (!file_exists($file)) {
	$this->warning =  &new BifWarning(array('TEXT' => "$file doesn't exist."));
      } else {

	// openings problems
	if (!($fp = fopen($file, 'r'))){
	  die("FATAL ERROR: Can't open file <b>$file</b> for reading. at " . __FILE__ );
	}
	$tmp = fread($fp,filesize($file) );
	fclose($fp);
	$included=&new BifRawText(array('TEXT' => $tmp));
	$this->addChild($included);
      }
    }

  function _clean($string) {
    // Delete whats before <BODY> (thats <HEAD> and  others)
    $string =  stristr($string,"<body"); 
    // Delete tag <BODY> itself 
    $string = ereg_replace('^<body[^\>]*>','<div style="BifInclude-doc">',$string);
    // Delete colsing tags: </BODY> and </HTML
    $string = str_replace("</body>\n</html>",'</div>',$string);
    return $string;
  }
}
// }}}
?>
