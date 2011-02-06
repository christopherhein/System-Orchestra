<?php
/**
* Hooks File
*
* Setup File Inclusion through classes and controllers, models, and views
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

class Hooks {
  private $url;
  private $page_num;
  private $default;
  private $pages;
  private $core;
  private $controller;
  private $action;
  private $id;
  private $format;
  private $post;
  private $params = array();
  private $cname;
  
  
  public function __construct() {
    $this->clear();
    $this->build();
    $this->setup_hook();
  }
  
  public function setup_hook() {
    extract($this->core);
    
    if($this->url != "") {
      $this->find_route();
      $this->cname = $this->build_controller($this->controller);
      $this->__autoload($this->controller, "controller");
      $this->build_params();
      $this->load();
    } else {
      if(isset($this->default) && $this->default != NULL) {
        $this->controller = $this->default['controller'];
        $this->action = $this->default['action'];
        $this->cname = $this->build_controller($this->controller);
        $this->__autoload($this->controller, "controller");
        $this->load();
      } else {
        include("landing.php");
      }
    }
  }

  public function build_params() {
    $params[0] = $this->format;
    if($this->action == "show" || $this->action == "edit" || $this->action == "destroy") {
      $params[1] = $this->id;
    } elseif($this->post != NULL) {
      $params[1] = $this->post;
    }
    $this->params = $params;
  }
  
  public function find_route() {
    $this->get_format();
    if(array_key_exists($this->url, $this->pages)) {
      $this->controller = $this->pages["$this->url"]["controller"];
      $this->action = $this->pages["$this->url"]["action"];
    } else {
      $url_expanded = explode("/", $this->url);
      if(end($url_expanded) == "") { $trailing = array_pop($url_expanded); }
      $this->controller = $url_expanded[0];
      if(isset($url_expanded[1])) {
        $this->id = $url_expanded[1]; 
      }
      if(!isset($url_expanded[2])) {
        $this->action = "show";
      } else {
        $this->action = $url_expanded[2];
      }
    }
  }

  public function get_format() {
    $format = explode(".", $this->url);
    $this->url = $format[0];
    isset($format[1]) ? $this->format = $format[1] : $this->format = "php";
  }
  
  public function build_controller($controller) {
    extract($this->core);
    $cname = ucfirst(strtolower($inflect->pluralize($controller)))."Controller";
    return $cname;
  }

  public function load($params = array()) {
    $dispatch = new $this->cname( $this->controller, $this->action );
    if(method_exists($dispatch, $this->action)) {
      if(method_exists($dispatch, "before_filter")) {
        call_user_func_array(array($dispatch, "before_filter"), $params);
      }
      call_user_func_array(array($dispatch, $this->action), $this->params);
      if(method_exists($dispatch, "after_filter")) {
        call_user_func_array(array($dispatch, "after_filter"), $params);
      }
    } else {
			$this->not_found();
    }
  }
  
  // Error Types: E_WARNING, E_NOTICE, E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE, E_RECOVERABLE_ERROR, E_ALL
  public function generate_error($message, $error_type) {
    extract($this->core);
    trigger_error($message.' '.$app['base_path'].$this->url.' from: '.$http->server_addr(), $error_type);
  }
  
  public function __autoload( $file, $type ){
    switch($type) {
      case "controller":
        $new_file = str_replace('-', '_', strtolower($file));
        $controller_url = CONTROLLERS.$new_file.'_controller.php';
        if(file_exists($controller_url)) { 
          require_once($controller_url); 
        } else {
          $this->not_found();
        }
      break;
      default:
        $this->not_found();
      break;
    } 
  }
  
  public function not_found() {
    extract($this->core);
    $this->generate_error('404 page recieved!', E_USER_NOTICE); // Error messages
    if($app['status'] == "production") { header("HTTP/1.0 404 Not Found"); header("location: /404.php"); }
    exit();
  } 
  
  public function build() {
    global $url;
    global $page_num;
    global $default;
    global $pages;
    global $core;
    
    $this->url = $url;
    $this->page_num = $page_num;
    $this->default = $default;
    $this->pages = $pages;
    $this->core = $core;
    isset($_POST) ? $this->post = $_POST : $this->post = NULL;
  }

  public function clear() {
    $this->url = NULL;
    $this->page_num = NULL;
    $this->default = NULL;
    $this->pages = NULL;
    $this->core = NULL;
    $this->controller = NULL;
    $this->action = NULL;
    $this->id = NULL;
    $this->format = NULL;
    $this->post = NULL;
  }
  
  
}