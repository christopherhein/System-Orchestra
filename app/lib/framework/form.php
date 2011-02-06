<?php
/**
* Form Helpers
*
* Any form helpers
*
* Licensed under the MIT license.
*
* @category   Orchestra
* @copyright  Copyright (c) 2010, Christopher Hein
* @license    http://orchestramvc.chrishe.in/license
* @version    Release: 0.0.1:beta
* @link       http://orchestramvc.chrishe.in/docs/lib/controllers/application/
*
*/
class Form {
	
  public function __construct() {
	
  }
	
	public function form_for($url, $options = array()) {
	  global $app;
		$form = "<form action='/$url' ";
		while(list($k, $v) = each($options)) {
			$form .= "$k='$v' ";
		}
		$form .= "> \n";
		$form .= "<input type='hidden' value='".$app['orch-token']."' name='orch-token'/>";
		return $form;
	}
	
	public function endform() {
		return "\n </form> \n";
	}
	
	public function input($options = array()) {
		$form = "<input ";
		while(list($k, $v) = each($options)) {
		  if($k == "value") {
		   $form .= "$k='".$this->ifset($v)."' "; 
		  } else {
		   $form .= "$k='$v' ";
		  }
		}
		$form .= "/>";
		return $form;
	}
	
	public function textarea($value, $options = array()) {
		$form = "<textarea ";
		while(list($k, $v) = each($options)) {
			$form .= "$k='$v' ";
		}
		$form .= ">".stripslashes($this->ifset($value))."</textarea>";
		return $form;
	}
	
	public function ifset($var) {
	  if(isset($var) && $var != "" && $var != NULL) {
	    return $var;
	  } else {
	    return "";
	  }
  }
  
}