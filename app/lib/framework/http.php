<?php
/**
* Application Http
*
* Global Http
*
* Licensed under the MIT license.
*
* @category   Orchestra
* @copyright  Copyright (c) 2010, Christopher Hein
* @license    http://orchestramvc.chrishe.in/license
* @version    Release: 0.0.1:beta
* @link       http://orchestramvc.chrishe.in/docs/lib/framework/http/
*
*/
class Http {

	public function __construct() {
	}
	
	public function server() {
    $server['addr'] = $this->server_addr();
    $server['name'] = $this->server_name();
    $server['software'] = $this->server_software();
    $server['protocol'] = $this->server_protocol();
    return $server;
	}
	
	public function host() {
	  $host['request-method'] = $this->request_method();
    $host['host'] = $this->host_addr();
    if($this->referrer() != "") {
      $host['referrer'] = $this->referrer();
    }
    $host['user-agent'] = $this->user_agent();
    $host['ip'] = $this->ip();
    return $host;
	}
	
	public function server_addr() {
	  return $_SERVER['SERVER_ADDR'];
	}
	
	public function server_name() {
	  return $_SERVER['SERVER_NAME'];
	}
	
	public function server_software() {
	  return $_SERVER['SERVER_SOFTWARE'];
	}
	
	public function server_protocol() {
	  return $_SERVER['SERVER_PROTOCOL'];
	}
	
	public function request_method() {
	  return $_SERVER['REQUEST_METHOD'];
	}
	
	public function host_addr() {
	  return $_SERVER['HTTP_HOST'];
	}
	
	public function referrer() {
	  if(isset($_SERVER['HTTP_REFERER'])) {
	    return $_SERVER['HTTP_REFERER'];
    }
	}
	
	public function user_agent() {
	  return $_SERVER['HTTP_USER_AGENT'];
	}
	
	public function ip() {
	  return $_SERVER['REMOTE_ADDR'];
	}
	
}