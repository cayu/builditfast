<?php
include_once('bifConfig.inc.php');
$num = $_SESSION['_BifApplication']->getParameter('num');
$root =&render_file('Contenido/index.bif',array("NUM" => $num));
print $root->draw();
?>
