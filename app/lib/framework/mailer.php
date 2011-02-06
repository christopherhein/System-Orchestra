<?php
/**
* Application Email
*
* Global Mailer
*
* Licensed under the MIT license.
*
* @category   Orchestra
* @copyright  Copyright (c) 2010, Christopher Hein
* @license    http://orchestramvc.chrishe.in/license
* @version    Release: 0.0.1:beta
* @link       http://orchestramvc.chrishe.in/docs/lib/framework/mailer/
*
*/
class Mailer {
	protected $_name;
	protected $_address;
	protected $_port;
	protected $_domain;
	protected $_authentication;
	protected $_user_name;
	protected $_password;
	protected $_mime;
	protected $_content_type = "plain";
	protected $_header;
	protected $_to;
	protected $_to_name = "";
	protected $_subject;
	protected $_body;

	public function __construct() {
		global $core;
		extract($core);
		
		$this->_name = $mail[$app['status']]['name'];
		$this->_address = $mail[$app['status']]['address'];
		$this->_port = $mail[$app['status']]['port'];
		$this->_domain = $mail[$app['status']]['domain'];
		$this->_authentication = $mail[$app['status']]['authentication'];
		$this->_user_name = $mail[$app['status']]['user_name'];
		$this->_password = $mail[$app['status']]['password'];
		$this->setup_ini();
	}
	
	public function setup_ini() {
		ini_set("SMTP", "$this->_address" ); 
		ini_set("sendmail_from", "$this->_user_name");
	}
	
	public function header($options = array()) {
		$this->_header .= "Return-Path: <$this->_user_name>\r\n";
		$this->_header .= "Delivered-To: <$this->_to>\r\n";
		$this->_header .= "From: $this->_name <$this->_user_name>\r\n";
		$this->_header .= "To: $this->_to_name <$this->_to>\r\n";
		$this->_header .= "Subject: $this->_subject\r\n";
		$this->_header .= "X-Mailer: Orchestra MVC, 0.0.1:beta\r\n";
		$this->_header .= "MIME-Version: $this->_mime\r\n";
		if($this->_content_type == 'html') {
			$this->_header .= "Content-type: text/html; charset=iso-8859-1\r\n";
		} else {
			$this->_header .= "Content-type: text/plain; charset=iso-8859-1\r\n";
		}
	}
	
	public function mailer($options = array()) {
		extract($options);
		$this->_to = $to;
		$this->_to_name = $to_name;
		$this->_subject = $subject;
		$this->_body = $body;
		if(isset($mime)) { $this->_mime = $mime; } else { $this->_mime = 1.0; }
		if(isset($content_type)) { $this->_content_type = $content_type; } else { $this->_content_type = "plain"; }
		$this->header();
	}
	
	public function send() {
		$send = mail($this->_to, $this->_subject, $this->_body, $this->_header);
		if($send) { return true; } else { return false; }
	}
	
	public function page($file, $options = array()) {
  	global $core;
		extract($core);
		extract($options);
		
		$sep = explode('/', $file);
		$file = file_get_contents('../app/views/'.$sep[0].'/_'.$sep[1].'.html.orc');
		return $file;
	}
	
}



