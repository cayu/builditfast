<?php

/************************************************************
 * bifConfig.php User configuration file
 * -------------------------------------
 * 
 * This file has user specific parameters. Edit at your will.
 * If unsure, leave the default value.
 *
 ************************************************************
 * comments? join bif-devel@listas.lunix.com.ar
 ************************************************************/

// Where BIF is installed.
// Examples:
//
//$sys_dir=dirname(__FILE__);  // Actual dir
//$sys_dir='/home/usuario/bif3';
$sys_dir='/usr/share/bif3';

// Session name should be unique for each application 
$bifcfg['session_name']        = 'hello-bif-world';

// Database config
/*
$bifcfg['DB']['phptype']       = 'mysql';     // PEAR's DB type
$bifcfg['DB']['host']          = 'localhost'; // MySQL hostname
$bifcfg['DB']['port']          = '';          // MySQL port - leave blank for default port
$bifcfg['DB']['socket']        = '';          // Path to the socket - leave blank for default socket
$bifcfg['DB']['connect_type']  = 'tcp';       // How to connect to MySQL server ('tcp' or 'socket')
$bifcfg['DB']['auth_type']     = 'config';    // Authentication method (config, http or cookie based)?
$bifcfg['DB']['user']          = 'user';      // MySQL user
$bifcfg['DB']['password']      = 'password';  // MySQL password
$bifcfg['DB']['database']      = 'database';  // Database
*/
/*
* AUTHENTICATION!
$bifcfg['Auth']['param'] = "mysql://user:password@localhost/table";
$bifcfg['Auth']['table'] = "auth";

*/

// Where the application it's going to be executed.
$app_dir=dirname(__FILE__);

$bifcfg['Skin']['file']    = "$app_dir/skins.txt"; // skin configuration

/************************************************************
 *************       End of user setup        ***************
 ************************************************************/

// Where the application it's going to be executed.
$app_dir=dirname(__FILE__);

include_once("$sys_dir/Base/Bif.php");

// execute component action (in case there is one, of course)
$_SESSION['_BifApplication']->execAction();

?>
