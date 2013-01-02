<?php

/************************************************************
 * bifConfig.php Archivo de configuracion de usuario
 * -------------------------------------------------
 *
 * This file has user specific parameters. Edit at your will.
 * Si no esta seguro, deje los valores por defecto.
 *
 ************************************************************
 * comments? join bif-devel@listas.lunix.com.ar
 ************************************************************/

// Directorio de instalacion de bif.
// Ejemplo:
//
//$sys_dir=dirname(__FILE__);  // Directorio actual
//$sys_dir='/usr/share/bif3';  // Instalacion multiple sitio
$sys_dir='../bif3-0.4.1';         // Instalacion dentro de un directorio local

// Session name should be unique for each application
$bifcfg['session_name']        = 'Agenda';

// Configuracion de la conexion con la base de datos

$bifcfg['DB']['phptype']       = 'mysql';     // PEAR's DB type
$bifcfg['DB']['host']          = 'localhost'; // MySQL hostname
$bifcfg['DB']['port']          = '';          // MySQL port - leave blank for default port
$bifcfg['DB']['socket']        = '';          // Path to the socket - leave blank for default socket
$bifcfg['DB']['connect_type']  = 'tcp';       // How to connect to MySQL server ('tcp' or 'socket')
$bifcfg['DB']['auth_type']     = 'config';    // Authentication method (config, http or cookie based)?
$bifcfg['DB']['user']          = 'cd4046';      // MySQL user
$bifcfg['DB']['password']      = '';  // MySQL password
$bifcfg['DB']['database']      = 'fotos';  // Database

// Configuracion de autenticacion
/* 

$bifcfg['Auth']['mode'] = 'system';
$bifcfg['Auth']['mode'] = 'site';
$bifcfg['Auth']['param'] = "mysql://user:pass@localhost/basededatos";
$bifcfg['Auth']['table'] = 'auth';
$bifcfg['Auth']['reload'] = 'false';

$bifcfg['Auth']['anonymous_username'] = 'anonymous';
$bifcfg['Auth']['anonymous_level'] = '50';
$bifcfg['Auth']['anonymous_keys'] = '';
*/

// i18n
// uncomment if using i18n
/*
$bifcfg['i18n']['supported'] = array('English' => 'en',
				     'Español' => 'es',
				     );
$bifcfg['i18n']['default']   = 'en';
*/

//Configuracion de bif_debug
/*
$bifcfg['debug']['level']='1';
*/

// Desde donde se ejecuta la aplicacion.
$app_dir=dirname(__FILE__);

$bifcfg['Skin']['file']    = "$app_dir/skins.txt"; // skin configuration

/************************************************************
 *************       End of user setup        ***************
 ************************************************************/

// Inclucion de BiF. Anteponer un @ para evitar warnings innecesarios
include_once("$sys_dir/Base/Bif.php");

// execute component action (in case there is one, of course)
$_SESSION['_BifApplication']->execAction();

?>
