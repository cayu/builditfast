<?
/**
 * This file hold class ReadRSS
 * @package BIF3
 */

/**
 * Required files
 */
 global $sys_dir;
 require_once("$sys_dir/Widgets/Contrib/lastRSS.php");
// {{{ class ReadRSS
/**
 * Widget Lector de RSS 
 * 
 * @package  BIF3
 * @subpackage Widgets/Contrib
 * @author   Sergio Cayuqueo <linuxvarela@yahoo.com.ar>
 * @version  $Revision: 1.1.2.1 $
 */

class ReadRSS extends BifWidget {
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string RSS_URL Url del feed rss a leer
   * @parameter string CACHE_DIR Directorio donde depositar el cache
   * @parameter string CACHE_TIME Tiempo de duracion del cache.
   */
    function __construct($attrs = array()) {
        parent::__construct($attrs);
        }
    function innerDraw() {
        if ($this->attributes['RSS_URL']) {
 	  $rss_url=$this->attributes['RSS_URL'];
	}
	else {
	  $rss_url="";
	}
        if ($this->attributes['CACHE_DIR']) {
          $cache_dir=$this->attributes['CACHE_DIR'];
        }
	else {
	  global $app_dir;
	  $cache_dir=$app_dir."/cache/rss/";
	}
        if ($this->attributes['CACHE_TIME']) {
 	  $cache_time=$this->attributes['CACHE_TIME'];
	}
	else {
 	  $cache_time=3600;
	}  

	// create lastRSS object
	$rss = new lastRSS;
	// setup transparent cache
	$rss->cache_dir = $cache_dir;
	$rss->cache_time = $cache_time; // one hour

	// load some RSS file
	if ($rs = $rss->get($rss_url)) {
	foreach ($rs['items'] as $key){
		    $this->tpl->setVariable($key,$rs['items']);
		    $this->tpl->parse('item');
		}
	}
	else {
	    $this->warning =& new BifWarning(array("TEXT"=>"missing RSS_URL attribute"));
	}
 }
}
// }}}
?>
