<?php
/**
* Settings File
*
* Defining Base Level Orchestra Settings
* This are global functions that are setup for your convience to handle errors 
*
* Licensed under the MIT license.
*
* @category   Orchestra
* @copyright  Copyright (c) 2010, Christopher Hein
* @license    http://orchestramvc.chrishe.in/license
* @version    Release: 0.0.1:beta
* @link       http://orchestramvc.chrishe.in/docs/lib/framework/settings/
*
*/

/* Checking to see what the status of the Application is
    If it is in Development mode Errors are printed to display
    If in production errors are printed to logs
*/

class Settings {
  
  public function __construct() {
    $this->error_handling();
    $this->sessions();
    $this->rm_quotes();
    $this->unregister_globals();
  }
  
  public function error_handling() {
    global $app;
    if ( $app['status'] == 'development' ) {
    	error_reporting(E_ALL);
    	ini_set( 'display_errors', 'On' );
    } elseif( $app['status'] == 'test' ) {
    	error_reporting( E_ALL );
    	ini_set( 'display_errors', 'Off' );
    	ini_set( 'log_errors', 'On' );
    	ini_set( 'error_log', LOGS.'php_test_error.log' );
    } else {
    	error_reporting( E_ALL );
    	ini_set( 'display_errors', 'Off' );
    	ini_set( 'log_errors', 'On' );
    	ini_set( 'error_log', LOGS.'php_production_error.log' );
    }
  }

	public function sessions() {
		session_save_path(SESSIONS);
		ini_set("session.save_path", SESSIONS);
	}

  /* Remove Slashes from arrays and objests
  */
  public function rm_slashes( $obj ) {
  	$value = is_array( $obj ) ? array_map(array('self', 'rm_slashes'), $obj) : stripslashes( $obj );
  	return $obj;
  }

  /* For PHP Versions < 5.3 Remove Depreciated Magic Quotes
      For Other Versions Nothing Happens
  */
  public function rm_quotes() {
    if( get_magic_quotes_gpc() ) {
    	$_GET    = $this->rm_slashes( $_GET );
    	$_POST   = $this->rm_slashes( $_POST );
    	$_COOKIE = $this->rm_slashes( $_COOKIE );
    }
  }


  /* Unregister Globals
      Removing Security holes for injection.
  */
  public function unregister_globals() {
    if (!ini_get('register_globals')) {
      return;
    }
    if (isset($_REQUEST['GLOBALS']) || isset($_FILES['GLOBALS'])) {
      //
      // TODO WRITE IN ERRORS/ADD EMAIL NOTIFICATION OPTIONS ie: {die('GLOBALS overwrite attempt detected');} + Mail
      //
    }

      // Variables Not Unset
    $noUnset = array('GLOBALS',  '_GET',
                   '_POST',    '_COOKIE',
                   '_REQUEST', '_SERVER',
                   '_ENV',     '_FILES');
  
    $input = array_merge($_GET,    $_POST,
                       $_COOKIE, $_SERVER,
                       $_ENV,    $_FILES,
                       isset($_SESSION) && is_array($_SESSION) ? $_SESSION : array());

    foreach ($input as $k => $v) {
      if (!in_array($k, $noUnset) && isset($GLOBALS[$k])) {
          unset($GLOBALS[$k]);
      }
    }
  }
}