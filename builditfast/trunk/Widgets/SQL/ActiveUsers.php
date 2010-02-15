<?php
/**
 * This file hold class ActiveUsers
 * @package BIF3
 */
// {{{ class ActiveUsers
/**
 * Contador de usuarios activos
 * Basandose en intervalos de 5 minutos
 * Needs SQL Table:
 * <pre>
 * CREATE TABLE active_users (
 *  user_ip varchar(15) NOT NULL default '',
 *  time datetime default NULL
 * ) TYPE=MyISAM;
 * </pre>
 *
 * @package  BIF3
 * @subpackage Widgets/MySQL
 * @author   Sergio Cayuqueo <linuxvarela@yahoo.com.ar>
 * @version  $Revision: 1.1.2.2 $
 */
class ActiveUsers extends BifWidget {
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string INTERVAL intervalo de actualizacion
   */
            function __construct($param = array()) {
               parent::__construct($param);
	          }
            function innerDraw() {
    		global $REMOTE_ADDR;
	        $REMOTE_ADDR = $_SERVER["REMOTE_ADDR"];
        	  if (! $this->attributes['INTERVAL'] ) {
            	        $this->attributes['INTERVAL']='5';
                    }
	    //ver si la ip ya esta aqui
    	$ip_result = $_SESSION['_BifApplication']->execQuery("SELECT user_ip
			    FROM active_users WHERE user_ip='$REMOTE_ADDR'");
        //si la ip esta aqui, actualizar el tiempo
        if ($ip_result->numRows() == 0) {
    		     $_SESSION['_BifApplication']->execQuery("INSERT INTO
		 active_users(user_ip, time) VALUES('$REMOTE_ADDR', NOW())");
        } else {
	            $_SESSION['_BifApplication']->execQuery("UPDATE active_users SET
		    time=NOW() WHERE user_ip='$REMOTE_ADDR'");
                }
        // Borrar registros viejos de usuarios no activos
	            $_SESSION['_BifApplication']->execQuery("DELETE from active_users WHERE
		    time < DATE_SUB(NOW(), INTERVAL ".$this->attributes['INTERVAL']." MINUTE)");
        // Seleccionar los usuarios activos
        $active_query =  $_SESSION['_BifApplication']->execQuery("SELECT
	count(user_ip) as num_users FROM active_users WHERE time > DATE_SUB(NOW(),
	INTERVAL ".$this->attributes['INTERVAL']." MINUTE)");
        $active_result_num_users = $active_query->fetchRow(DB_FETCHMODE_ASSOC);
        $active_users = $active_result_num_users['num_users'];
        $this->tpl->setVariable('ACTIVEUSERS',$active_users);
        $this->tpl->parse('ITEM');
    }
 }
?>