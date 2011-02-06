<?php
/**
* Bootstrap File
*
* Initial File for booting up The Orchestra Application
* Laying out the file structure and everything flows through this file for Orchestra Projects 
*
* Licensed under the MIT license.
*
* @category   Orchestra
* @copyright  Copyright (c) 2010, Christopher Hein
* @license    http://orchestramvc.chrishe.in/license
* @version    Release: 0.0.1:beta
* @link       http://orchestramvc.chrishe.in/docs/config/boot/
*
*/

	// Core
require('definitions.php');
require('autoload.php');

foreach($require as $loc => $file) {
  foreach($file as $name) {
    switch($loc) {
      case "config":
        require_once("$name.php");
      break;
      case "framework":
        require_once(FRAMEWORK."$name.php");
      break;
      case "controllers":
        require_once(CONTROLLERS."$name.php");
      break;
      case "models":
        require_once(MODELS."$name.php");
      break;
    }
  }
}

if($app['haml'] == true) {
	require(LIB.'haml/haml/HamlParser.class.php');
	$core['haml']	= New HamlParser('../app/views/', HAML);
}

if(isset($_GET['url'])) {$url = $_GET['url'];};
if(isset($_GET['page'])) {$page_num = $_GET['page'];} else {$page_num = NULL;};

$core['app'] 								= $app;
$core['db'] 								= $db;
$core['display'] 						= $display;
$core['mail'] 							= $mail;
$core['upload'] 						= $upload;
$core['twit']               = $twitter;
$core['disq']               = $disqus;

foreach($autoload as $loc => $file) {
  foreach($file as $name) {
    $class_name = "";
    $classes = explode("_", $name);
    foreach($classes as $key => $class) {
      $class_name .= ucfirst($class);
    }
    switch($loc) {
      case "framework":
        require_once(FRAMEWORK."$name.php");
      break;
      case "addons":
        require_once(ADDONS."$name.php");
      break;
      case "helpers":
        require_once(HELPERS."$name.php");
      break;
    }  
    $core[$name] = New $class_name();
  }
}