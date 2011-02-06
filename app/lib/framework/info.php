<?php
/**
* Application Info
*
* Global Info
*
* Licensed under the MIT license.
*
* @category   Orchestra
* @copyright  Copyright (c) 2010, Christopher Hein
* @license    http://orchestramvc.chrishe.in/license
* @version    Release: 0.0.1:beta
* @link       http://orchestramvc.chrishe.in/docs/lib/framework/info/
*
*/
include(dirname(dirname(dirname(__FILE__)))."/instruments.orc");
include(dirname(dirname(dirname(__FILE__)))."/config/config.php");
include(dirname(dirname(dirname(__FILE__)))."/config/autoload.php");

class Info {

	public function __construct() {
		
	}
	
	public function instruments() {
	  global $orchestra;
	  return $orchestra;
	}
	
	public function version() {
	  return "0.0.1";
	}
	
	public function display() {
	  global $display;
	  return $display;
	}
	
	public function app() {
	  global $app;
	  return $app;
	}
	
	public function autoload() {
	  global $autoload;
	  return $autoload;
	}
	
	public function required() {
	  global $require;
	  return $require;
	}

}