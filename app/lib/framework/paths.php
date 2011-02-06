<?php
/**
* Application Paths
*
* Global Paths
*
* Licensed under the MIT license.
*
* @category   Orchestra
* @copyright  Copyright (c) 2010, Christopher Hein
* @license    http://orchestramvc.chrishe.in/license
* @version    Release: 0.0.1:beta
* @link       http://orchestramvc.chrishe.in/docs/lib/framework/paths/
*
*/
class Paths {
  private $string;
  private $controller;
  private $action;
  private $arguments;
  private $url;

	public function __construct() {
	  $this->string = NULL;
    $this->controller = NULL;
    $this->action = NULL;
    $this->arguments = "";
	}
	
	public function __call($name, $arguments = "") {
 	  global $pages;
    if (substr($name, -5) == '_path') {
      $this->string = substr($name, 0, -5);
      $string_expanded = explode("_", $this->string);
      $this->controller = $string_expanded[0];
      if(isset($string_expanded[1]) && $string_expanded[1] != "") {
        $this->action = $string_expanded[1];
      } else {
        $this->action = "index";
      }
      if($arguments != "" && isset($arguments[0][0]) && $arguments[0][0] != "") {
        $this->arguments = $arguments[0][0];
      }
      return $this->build_url();
    }
  }
	
	public function build_url() {
	  $this->url = "/".$this->controller."/";
	  if($this->arguments != "") {
	    $this->url .= $this->arguments."/";
	  }
	  if($this->action != "index") {
	    if($this->action != "show") {
        $this->url .= $this->action."/";
	    }
	  }
	  return $this->url;
	}

}