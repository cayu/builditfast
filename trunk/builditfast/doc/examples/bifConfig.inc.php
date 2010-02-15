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
$sys_dir='/usr/share/bif3';
//$sys_dir='/home/cd4046/bif/BIF3';

// Session name should be unique for each application 
$bifcfg['session_name']        = 'BIF3-site_example';

// Database config
/*
$bifcfg['DB']['phptype']       = 'mysql';     // PEAR's DB type
$bifcfg['DB']['host']          = 'localhost'; // DB hostname
$bifcfg['DB']['port']          = '';          // DB port - leave blank for default port
$bifcfg['DB']['socket']        = '';          // Path to the socket - leave blank for default socket
$bifcfg['DB']['connect_type']  = 'tcp';       // How to connect to DB server ('tcp' or 'socket')
$bifcfg['DB']['auth_type']     = 'config';    // Authentication method (config, http or cookie based)?
$bifcfg['DB']['user']          = 'user';      // DB user
$bifcfg['DB']['password']      = 'password';  // DB password
$bifcfg['DB']['database']      = 'database';  // Database
*/
/*
// AUTHENTICATION!
//$bifcfg['Auth']['file'] = '';
$bifcfg['Auth']['mode'] = 'system';
$bifcfg['Auth']['param'] = "mysql://user:password@localhost/database";
$bifcfg['Auth']['table'] = "auth";
$bifcfg['Auth']['reload'] = false;
*/

// i18n
// uncomment if using i18n
/*
$bifcfg['i18n']['supported'] = array('English' => 'en',
				     'Español' => 'es',
				     );
$bifcfg['i18n']['default']   = 'en';
*/

// Debugging
$bifcfg['debug']['level'] = 0;

// Where the application it's going to be executed.
$app_dir=dirname(__FILE__);

$bifcfg['Skin']['file']    = "$app_dir/skins.txt"; // skin configuration

/************************************************************
 *************       End of user setup        ***************
 ************************************************************/

include_once("$sys_dir/Base/Bif.php");

// execute component action (in case there is one, of course)
$_SESSION['_BifApplication']->execAction();

?>