<?php
/**
* Application notice
*
* Global notice
*
* Licensed under the MIT license.
*
* @category   Orchestra
* @copyright  Copyright (c) 2010, Christopher Hein
* @license    http://orchestramvc.chrishe.in/license
* @version    Release: 0.0.1:beta
* @link       http://orchestramvc.chrishe.in/docs/lib/framework/notice/
*
*/
class Notice {
  private $_notice_name;
  public $notices = array();

	public function __construct() {
	  if(isset($_COOKIE['flash'])) {
	    foreach($_COOKIE['flash'] as $key => $value) {
	      $this->notices[$key] = stripslashes($value);
	    }
	  }
	  $this->notice_clean(); 
	}
	
	public function push($notice = array()) {
	  $this->_notice_data = $notice;
	  foreach($notice as $key => $value) {
	    $notice_name = "flash[$key]";
	    setcookie($notice_name, $value, 2+time());
	  }
	}
	
	public function pull() {
	  return $this->notices;
	  $this->notices = array(); 
	}
	
	public function notice_clean() {
	  global $core;
	  global $url;
	  extract($core);
	  if(isset($_COOKIE['flash'])) {
	    foreach($_COOKIE['flash'] as $key => $value) {
  	    setcookie( "flash[$key]", "", time()-3600);
  	  }
    }
	}
	
}