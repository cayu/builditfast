<?php
include_once('bifConfig.inc.php');
$root =&render_file('Content/doc.bif');
print $root->draw();
?>
