<?php
/**
* Application Controller
*
* Sets up all the handling through views that get passed into the models
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
class ApplicationController {
 	protected $_controller;
 	protected $_action;
 	protected $_template;
 	public $render;

 	public function __construct($controller, $action) {
    global $core;
    extract($core);
    
 		$this->_controller = ucfirst($inflect->pluralize($controller));
 		$this->_action = $action;
    $model = $controller;
 		$this->render = "application";
 		$this->__autoload($inflect->singularize($model), "model");
 		$this->__autoload($inflect->pluralize($model), "helper");
 		$this->_template = new Template($controller, $action);

 	}
 	
 	public function __call($name, $arguments) {
 	  global $core;
 	  extract($core);
 	  if (substr($name, -5) == '_path') {
      return $paths->$name($arguments);
    } elseif($name == "notice") {
      $notice->push($arguments[0]);
    }
  } 

 	public function set($name, $value) {
 		$this->_template->set($name, $value);
 	}

	public function render($format, $content, $accept = array('all'), $file = NULL) {
		if(in_array($format, $accept) || in_array('all', $accept)) {
			$this->_template->format($format, $content, $file);
		} else {
			$this->_template->format('php', $content);
		}
	}
 	
 	public function __autoload($file, $type) {
 	  if($type == "model") {
   	  if(file_exists(MODELS . strtolower($file) . '.php')) {
     		require_once(MODELS . strtolower($file) . '.php');
     		$this->$file = new $file;
     		if(method_exists($this->$file, "before_filter")) {
       		call_user_func_array(array($this->$file, "before_filter"), array());
       		$hasmany = $this->$file->get_hasmany();
       		if($hasmany != false) {
       		  foreach($hasmany as $hm) {
       		    if(file_exists(MODELS . strtolower($hm) . '.php')) {
       		      require_once(MODELS . strtolower($hm) . '.php');
     		        $nm = ucfirst($hm);
     		        $this->$hm = new $nm;
     		        if(method_exists($this->$hm, "before_filter")) {
   		            call_user_func_array(array($this->$hm, "before_filter"), array());
   		          }
     		      }
       		  }
       		}
       		$has_many_belongs_to = $this->$file->get_has_many_belongs_to();
       		if($has_many_belongs_to != false) {
       		  foreach($has_many_belongs_to as $k => $v) {
       		    if(file_exists(MODELS . strtolower($k) . '.php')) {
       		      require_once(MODELS . strtolower($k) . '.php');
     		        $nm = ucfirst($k);
     		        $this->$k = new $nm;
     		        if(method_exists($this->$k, "before_filter")) {
   		            call_user_func_array(array($this->$k, "before_filter"), array());
   		          }
     		      }
     		      if(file_exists(MODELS . strtolower($v) . '.php')) {
       		      require_once(MODELS . strtolower($v) . '.php');
     		        $nm = ucfirst($v);
     		        $this->$v = new $nm;
     		        if(method_exists($this->$v, "before_filter")) {
   		            call_user_func_array(array($this->$v, "before_filter"), array());
   		          }
     		      }
       		  }
       		}
     		}
     	}
 	  } elseif($type == "helper") {
   	  if(file_exists(HELPERS . strtolower($file) . '_helper.php')) {
     		require_once(HELPERS . strtolower($file) . '_helper.php');
     		$class = $file."_helper";
     		$file_name = ucfirst($file)."Helper";
     		$this->$class = new $file_name;
     	}
   	}
 	}

 	public function __destruct() {
 		if ($this->render) {
 			$this->_template->render($this->render);
 		}
 	}
	
	public function redirect_to($path) {
		header("location: $path");
		exit();
	}

}