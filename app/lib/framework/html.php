<?php
/**
* HTML Helpers
*
* Any HTML helpers
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
class Html {
	
  public function __construct() {
	
  }
	
	public function stylesheet_link($src, $options = array(), $type = NULL) {
		$link = "<link href='$src' ";
		while(list($k, $v) = each($options)) { 
			$link .= "$k='$v' ";
		}
		switch($type) {
			case 'less':
				$link .= "rel='stylesheet/less'";
			break;
			default:
				$link .= "rel='stylesheet'";
			break;
		}
		$link .= "/>\n";
		if($this->file_exists($src, array('css')) == true) {
			return $link;
		} else {
			return "";
		}
	}
	
	public function javascript_link($src, $options = array()) {
		$link = "<script src='$src' ";
		while(list($k, $v) = each($options)) {
			$link .= "$k='$v' ";
		}
		$link .= "></script>\n";
		if($this->file_exists($src, array('js')) == true) {
			return $link;
		} else {
			return "";
		}
	}
	
	public function a($link, $text, $options = array()) {
		$link = "<a href='$link' ";
		while(list($k, $v) = each($options)) {
			$link .= "$k='$v' ";
		}
		$link .= ">$text</a>\n";
		return $link;
	}
	
	public function img($src, $options = array()) {
		$img = "<img src='$src' ";
		while(list($k, $v) = each($options)) {
			$img .= "$k='$v' ";
		}
		$img .= " />";
		if(file_exists(FRONTEND.$src) && $src != '') {
			return $img;
		} else {
			return "";
		}
	}
	
	public function trim($string, $limit, $link = NULL, $break = '...') {
		$trim = substr($string, 0, $limit);
		$trim = trim($trim);
		if($link != NULL) {
			$trim .= $break." <a href='".$link."' class='more-link'>More »</a>";
		} else {
			$trim .= $break;
		}
		return $trim;
	}
	
	public function file_exists($file, $format = array()) {
		if(file_exists(ROOT.'/frontend'.$file)) {
			return true;
		} elseif(file_exists(APP.'stylesheets'.$file.'.pcss')) {
			return true;
		} elseif(file_exists(VIEWS.$file.'.pjs')) {
			return true;
		} elseif(file_exists(VIEWS.$file)) {
			return true;
		} else {
			return false;
		}
	}
  
}