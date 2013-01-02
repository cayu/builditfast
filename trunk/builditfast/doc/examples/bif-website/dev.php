<?php
include_once('bifConfig.inc.php');
$root =&render_file('Content/dev.bif');
print $root->draw();
?>
