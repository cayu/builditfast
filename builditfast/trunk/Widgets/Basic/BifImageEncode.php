<?php
/**
 * This file holds class BifImageEncode
 * @package  BIF3
 */
// {{{ class BifImageEncode
/**
 * Widget para encondear y embeber imagenes
 *
 * <img src="data:image/png;base64, $data" /> tag in most cases, (a is an HTMLTag widget)
 *
 * @package  BIF3
 * @subpackage Widgets/Basic
 * @author   Sergio Cayuqueo <linuxvarela@yahoo.com.ar>
 * @version  $Revision: 1.1.2.1 $
 */
class BifImageEncode extends BifWidget {
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string SRC Image's source.Must be specified and file must exists. 
   * @parameter string ALT Image's ALT.
   * @parameter string NAME Image's NAME.
   */
  function __construct($attrs = array()) {
    parent::__construct($attrs);
  }
  function innerDraw() {
    $file = $this->attributes["SRC"];

    if (ereg("(.*://)",$file,$regs)) {
      $this->warning =  &new BifWarning(array(
	"TEXT" => "SRC attribute invalid.(contains '$regs[1]')"));      
    } else if($file == "") {
      $this->warning =  &new BifWarning(array(
	"TEXT" => "SRC attribute not specified."));
    } else if (! file_exists($file)) {
      $this->warning =  &new BifWarning(array(
        "TEXT" => "$file doesn't exist."));
    } else {
      $tmp=getimagesize($file);
      $this->attributes["SIZE"]=$tmp[3];

if($fp = fopen($file,"rb", 0))
{
   $picture = fread($fp,filesize($file));
   fclose($fp);
   // base64 encode the binary data, then break it
   // into chunks according to RFC 2045 semantics
   $base64 = chunk_split(base64_encode($picture));
 }
      $this->tpl->setVariable('DATA',$base64);
       $this->HTMLfields=array("ALT","NAME");
    }
  }
}
// }}}
?>
