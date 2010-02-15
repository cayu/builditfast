<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */


// Make sure it's included only once
if(defined("BIF")) return;
define("BIF", 1);

// Check if it's been included alone
if (! isset($app_dir)) {
  die('
Bif.php should only be included by bifConfig.inc.php.<br>
use <tt>include_once(\'bifConfig.inc.php\' instead');
}
// Just to be sure we have the correct sys_dir
$sys_dir=dirname(dirname(__FILE__));

if (!isset($pear_dir)) {
  $pear_dir = "$sys_dir/PEAR";
  require_once('PEAR.php'); // PEAR core support.
  require_once("$pear_dir/HTML/Template/Sigma.php");
}
// we don't use cookies
ini_alter("enable_trans_sid","1");
ini_alter("session_use_cookies","0");


include_once("$sys_dir/Base/bif_debug.php");       // bif_debug function
include_once("$sys_dir/Base/Check.php");           // check_* functions
include_once("$sys_dir/Base/util.php");            // utility functions
include_once("$sys_dir/Base/Application.php");     // main application object
includeSysAndApp('Widgets/Base');		   // avoid SuSE problems
includeSysAndApp('Widgets');                       // System and application Widgets
// The Render needs HTMLTag widget to work.
include_once("$sys_dir/Base/Render.php");          // Render for .bif files
include_once("$sys_dir/Base/Component.php");       // Component
includeSysAndApp('Components');                    // System and application Components
include_once("$sys_dir/Base/Skin.php");            // Component
includeSysAndApp('Skins');                         // System and application Skins



/*
 * SECTION: Session
 * -----------------
 * _BifApplication is the main global object that
 * represents the application and is saved
 * in session. It holds all components, database
 */

// Init or restarts the session
if (isset($bifcfg['session_name'])) {
  $sessionname = $bifcfg['session_name'];
} else {
  $sessionname = 'bif3_sid';
}
session_name($sessionname);
session_start();

if(!session_is_registered('_BifApplication')){
  $_SESSION['_BifApplication'] =& new Application;
  session_register('_BifApplication');
}
$_SESSION['_BifApplication']->loadAllComponents();

/*
 * SECTION: i18n stuff
 * -------------------
 *
 */
if (isset($bifcfg['i18n'])) {
  $cfg = $bifcfg['i18n'];

  $tmp = explode(";",$_SERVER["HTTP_ACCEPT_LANGUAGE"]);
  $accept_lang =  explode(',',$tmp[0]);
  assert(is_array($accept_lang));   

  if ($session_lang = $_SESSION['_BifApplication']->getVar('lang') ) {
    array_unshift($accept_lang,$session_lang);
  }

  if ($param_lang = $_SESSION['_BifApplication']->getParameter('bif_lang')) {
    array_unshift($accept_lang,$param_lang);
  }

  /**
   * FYI:
  $accept_lang = array (<parameter bif_lang> , 
                        <variable lang in session>, 
                        <client configuration> );
  */
  $stay=true;
  while ($tmp_lang=array_shift($accept_lang) AND $stay) {
    if (! in_array($tmp_lang,$cfg['supported'])) {
      $lang =  $cfg['default']; // default
    } else {
      $lang=$tmp_lang;
      $stay=false;
    }
  }

  $_SESSION['_BifApplication']->setVar('lang',$lang);
}
/*
 * SECTION: Load Skins
 * -------------------
 * creates instances of skins based in bifcfg['Skin']
 * Should be called here because includes definition of session stored objects!
 */


$file    = $bifcfg['Skin']['file'];
if(!file_exists($file)) {
  die("Skins file: '$file' doesn't exist (".__FILE__ . " in " . __LINE__.")<br> Check \$bifcfg['Skin']['file'] in </b>bifConfig.inc.php</b>");
}
if(!$fp=@fopen($file,'r')) {
  die("Can't open skin file: '$file' \n");
}

$skins = array();

while (!feof($fp)) {
  $line=fgets($fp,4000);
  if (!ereg('^ *#',$line) && $line!='') {    // ignore coments in skins file
    ereg('([A-Za-z]*)',$line,$regs);
    $skin=chop($regs[1]);
    array_unshift($skins, new $regs[1]);
  }
}
fclose($fp);

$_SESSION['_BifApplication']->skins = $skins;

/*
 * SECTION: Load Skins
 * -------------------
 * creates instances of skins based in bifcfg['Skin']
 * Should be called here because includes definition of session stored objects!
 */


$file    = $bifcfg['Skin']['file'];
if(!file_exists($file)) {
  die("Skins file: '$file' doesn't exist (".__FILE__ . " in " . __LINE__.")<br> Check \$bifcfg['Skin']['file'] in </b>bifConfig.inc.php</b>");
}

if(!$fp=@fopen($file,'r')) {
  die("Can't open skin file: '$file' \n");
}

$skins = array();

while (!feof($fp)) {
  $line=fgets($fp,4000);
  if (!ereg('^ *#',$line) && $line!='') {    // ignore coments in skins file
    ereg('([A-Za-z]*)',$line,$regs);
    $skin=chop($regs[1]);
    array_unshift($skins, new $regs[1]);
  }
}
fclose($fp);

$_SESSION['_BifApplication']->skins = $skins;

/*
 * SECTION: Database
 * -----------------
 * Application saves the connection to the database into session
 * in this section it's initialized.
 */

if (isset($bifcfg['DB'])) {
  $cfg = $bifcfg['DB'];
  $dsn = $cfg['phptype'] . '://'. $cfg['user']  . ':' .$cfg['password'] . '@' .
    $cfg['host'] . '/' . $cfg['database'];

  $_SESSION['_BifApplication']->database = DB::connect($dsn);
  if (DB::isError($_SESSION['_BifApplication']->database)) {

    bif_debug (__FILE__ . ' line <b>'. __LINE__ .'</b>: ' .
	 $_SESSION['_BifApplication']->database->getMessage() . " (dsn='$dsn')<br><br>");

    bif_debug ( "(For mysql) Probably you have to create the database and give privileges (as root):
<pre>
create database ".$cfg['database'].";
grant all privileges
  on ".$cfg['database'].".*
  to ".$cfg['user']."@". $cfg['host'] ."
  identified by '".$cfg['password']."';
flush privileges;
</pre>
"
);
    die();
  }
}

/*
 * SECTION: Authentication
 * -----------------------
 * Application->auth has an PEAR's Auth::Auth object.
 */

function loginFunction()
{
    global $PHP_SELF;
    global $bifcfg;
    $_msg='';

    if ('AUTH_IDLED' == $_SESSION['_BifApplication']->getVar('user_auth')) {
      // $_msg= '';
    }
    if ('AUTH_EXPIRED' == $_SESSION['_BifApplication']->getVar('user_auth')) {
      // $_msg= 'Expiró el tiempo de autenticacion, vuelva a intentar';
    }
    if ('AUTH_WRONG_LOGIN' == $_SESSION['_BifApplication']->getVar('user_auth')) {
       $_msg= 'Nombre o contraseña inválida.';
     }
if (isset($bifcfg['Auth']['file'])) {
$root =& render_file($bifcfg['Auth']['file'], array('MESSAGE'=>$_msg));  
}else {
  $root =& render('
<BifRoot title="Login">
<div align="center">
<table><tr><td width="200">
<TitleBox  title="Login">
<Font size="+1" color="#AA0000">{MESSAGE}</Font>
<ft method="POST">
<fttext name="username" />
<ftpassword name="password" />
<ftsubmit value="Ingresar" />
<formhidden name="bifLogin" value="1"/>
</ft>
</TitleBox>
</td></tr></table>
</div>
</BifRoot>
', array('MESSAGE'=>$_msg));  
}
  print $root->draw();
  die();
}

function bifLogin() {
  global $bifcfg;
  if (isset($bifcfg['Auth'])) {
    $_SESSION['_BifApplication']->setVar('user_auth','logging');
    loginFunction();
  } else {
    die ("bifLogin() can't be executed, \$bifcfg['Auth'] not set!! check bifConfig.inc");
  }
}

function bifLoginCheck($u,$p,$dsn,$table='auth',$userCol='username',$passCol='password') {

  // Connect to database
  $db = DB::connect($dsn);
  if (DB::isError($dsn)) {
    bif_debug (__FILE__ . ' line <b>'. __LINE__ .'</b>: ' .
	  $db->getMessage() . " (dsn='$dsn')<br><br> " .
	  'Check <b>$bifcfg[\'Auth\']</b> in configuration file.');
    die();
  };
  
  $query ="select * from $table where $userCol='$u'";
  $rst   = $db->query($query);
  if (DB::isError($rst)) {
    bif_debug ("Error trying to get authentication table.<br>\n" .
	       "Query was:<pre>$query</pre><br>\n" .
	       $rst->getMessage());
    die();
  }
  $row   = $rst->fetchRow(DB_FETCHMODE_ASSOC);
  $storedPass =   $row[$passCol];

  // encrypt method
  $enc='md5';
  if ($enc($p) == $storedPass) {   
    return true;
  } else { 
    return false;
  }
}

if (isset($bifcfg['Auth'])) {
  // authStatus could be:
  // logged     : user/passwd
  // anonymous  : is an anonymous user
  // logging    : user is logging (she is sending username and password)
  // unset      : fist time arround? we'll fix that in a moment.;-)

  $authStatus = $_SESSION['_BifApplication']->getVar('user_auth');

  // Database table that holds autentication.
  if (! $bifcfg['Auth']['table']) {
    $table = "auth";
  } else {
    $table = $bifcfg['Auth']['table'];
  };
  
  // $params is dsn to connect to database!
  // ex. 'mysql://user:pass@localhost/database'
  $dsn = $bifcfg['Auth']['param'];
  
  switch ($authStatus) {
  case '':
    // correct unset problem
    $authStatus = 'anonymous';
    break;
  case 'logging':
    $_user = $_SESSION['_BifApplication']->getParameter('username') ;
    $_pass = $_SESSION['_BifApplication']->getParameter('password') ;    

    if (bifLoginCheck($_user,$_pass,$dsn,$table)) {
      $_SESSION['_BifApplication']->setVar('user_username',$_user);
      $authStatus = 'logged';
    } else {
      // error reporting... (ex. invalid password)
    }
    break;
  }

  // authMode is 'system' or 'site' (for now)
  // system (wide):  all pages in the system require auth
  // site:          some pages/widget require auth.
  if (! $bifcfg['Auth']['mode']) {
    $authMode   = 'system';
  } else {
    $authMode = strtolower($bifcfg['Auth']['mode']);
  };

  if ($authStatus == 'logged') {
    $logged = true;
  } else {
    $logged = false;
  }

  // Reload each time user info??
  // if false, will use session values, 
  // if true: less performance... but all user info will be up-to-date
  if (! $bifcfg['Auth']['reload']) {
    $authReload = true;
  } else {
    $authReload = $bifcfg['Auth']['reload'];
  };

  if ($authStatus == 'anonymous' AND $authReload) {
    //set default anonymous values
    foreach (array('username','level','keys') as $a) {
      $_SESSION['_BifApplication']->setVar("user_$a", $bifcfg['Auth']["anonymous_$a"]);
    }
  }

  switch ($authMode) {
  case 'system':
    if  (! $logged) {
      bifLogin();
    }
    break;
  case 'site':
    if (! $logged) {
      $_user = $_SESSION['_BifApplication']->getParameter('username') ;
      $_pass = $_SESSION['_BifApplication']->getParameter('password') ;
      $_need_login =  $_SESSION['_BifApplication']->getParameter('bifLogin') ;
      if ($_need_login AND  $_user) {
	if (bifLoginCheck($_user,$_pass,$dsn,$table)) {
	  $_SESSION['_BifApplication']->setVar('user_username',$_user);
	$authStatus = 'logged';
	$logged = true;
	}
      }
    }
    break;
  default:
    die("FATAL ERROR: Invalid Autentication Mode: '$authMode' (".$bifcfg['Auth']['mode'].")");
  }

  //update changes --in session--
  $_SESSION['_BifApplication']->setVar('user_auth',$authStatus);

  if  ($logged AND $authReload) {
    // get user info from $dsn
    $db = DB::connect($dsn);
    if (DB::isError($db)) {
      bif_debug (__FILE__ . ' line <b>'. __LINE__ .'</b>: ' .
	    $db->getMessage() . " (dsn='$dsn')<br><br> " .
	    'Check <b>$bifcfg[\'Auth\']</b> in configuration file.');
      die();
    };
    $u     = $_SESSION['_BifApplication']->getVar('user_username');
    $query = "select * from $table where username='$u'";
    $rst   = $db->query($query);
    // TODO: Check if table $table exists...
    $row   = $rst->fetchRow(DB_FETCHMODE_ASSOC);
    bif_debug("Releyendo la configuración del usuario desde la BD: '$query'",2);
    foreach (array_keys($row) as $a)
      {
	$_SESSION['_BifApplication']->setVar("user_$a",$row[$a]);
      }
    //BACKWARD COMPATIBILITY!!!
    //'username' not used anymore:
    //use 'user_username' instead!
    // --
    $_SESSION['_BifApplication']->setVar('username',$row['username']);
    //--
  }

  // Must erase $POST variables.
  // also allows to enter someware in the aplication after login... nice
  if ($authStatus == 'logged' && 
       $_POST['bifLogin'] == '1'
      ) {
    header("Location: ".$_SERVER['HTTP_REFERER']);
    die();
  }

  if ( $_SESSION['_BifApplication']->getParameter('logout') ) {
    $_SESSION['_BifApplication']->unSetAll("user");
    //  $_SESSION['_BifApplication']->auth->logout(); //¿¿y ahora??
    $_SESSION['_BifApplication']->initAllComponents();
    $_SESSION['_BifApplication']->_init = false;
    header("Location: ".$_SERVER['HTTP_REFERER']); // hay que ver si esto funciona
  }
}


if($_SESSION['_BifApplication']->_init ) {
  $_SESSION['_BifApplication']->initAllComponents();
  $_SESSION['_BifApplication']->_init = false;
}

?>