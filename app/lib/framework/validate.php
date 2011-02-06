<?php
/**
* Validation Helper
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
class Validate {
	protected $_fields;
	protected $_errors = array();
  
	public function __construct() {
	
  }
	
	public function validate($fields = array()) {
		$this->_fields = $fields;
		while(list($t, $v) = each($fields)) {
			switch($t) {
				case "email":
					$type[$t] = $this->email($t, $v);
				break;
				case "string":
					$type[$t] = $this->str($t, $v);
				break;
				case "integer":
					$type[$t] = $this->int($t, $v);
				break;
				case "array":
					$type[$t] = $this->arr($t, $v);
				break;
				default:
					$type[$t] = $this->is_empty($t, $v);
				break;
			}
		}
		foreach($type as $item) {
			if($item == false) {
				return $this->_errors;
			} else {
				return true;
			}
		}
	}
	
	public function errors() {
		if($this->_errors != NULL ) {
			$errors = "<h4>The following errors occured:</h4>\n";
			$errors .= "<ul>\n";
			while(list($k, $v) = each($this->_errors)) {
				$errors .= "<li><p>".ucfirst($k)." $v</p></li>\n";
			}
			$errors .= "</ul>"; 
			return $errors;
		}
	}
	
	public function email($name, $value) {
		if( !empty( $value ) ) {
			if( preg_match( "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $value ) ){
				list( $username, $domain ) = explode( '@', $value );
				if( !checkdnsrr( $domain,'MX') ) {
					$this->_errors[$name] = "Invalid DNS";
					return false;
				}
				return true;
			}
			$this->_errors[$name] = "Invalid Format";
			return false;
		}
		$this->_errors[$name] = "cannot be empty.";
		return false;
	}
	
	public function str($name, $value) {
		if(!empty($value)) {
			if(!is_string($value)) {
				return true;
			}
			$this->_errors[$name] = "Should be a string";
			return false;
		}
		$this->_errors[$name] = "cannot be empty.";
		return false;
	}
	
	public function int($name, $value) {
		if(!empty($value)) {
			if(!is_int($value)) {
				return true;
			}
			$this->_errors[$name] = "Should be an integer";
			return false;
		}
		$this->_errors[$name] = "cannot be empty.";
		return false;
	}
	
	public function arr($name, $value) {
		if(!empty($value)) {
			if(!is_array($value)) {
				return true;
			}
			$this->_errors[$name] = "Should be an array";
			return false;
		}
		$this->_errors[$name] = "cannot be empty.";
		return false;
	}
	
  public function is_empty($name, $value) {
		if(!empty($value)) {
			return true;
		}
		$this->_errors[$name] = "cannot be empty.";
		return false;
	}
}