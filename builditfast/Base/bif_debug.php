<?php

function bif_debug($obj,$level = 0) {
  global $bifcfg;
  if (isset($bifcfg['debug'])) {
    $cfg = $bifcfg['debug'];

    if (isset($cfg['level'])) {
      $cfg_level = $cfg['level'];
    } else {
      $cfg_level = 1;
    }
      if ($level <= $cfg_level) {
	echo "<pre>------[ bif_debug() ]-------\n";
	print_r($obj);
	echo "\n---------------------------\n</pre><br>";
      }
    
  }
}

?>