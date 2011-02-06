<?php
/**
* Application Uploader
*
* Global Benchmarking
*
* Licensed under the MIT license.
*
* @category   Orchestra
* @copyright  Copyright (c) 2010, Christopher Hein
* @license    http://orchestramvc.chrishe.in/license
* @version    Release: 0.0.1:beta
* @link       http://orchestramvc.chrishe.in/docs/lib/framework/benchmark/
*
*/
require(LIB.'framework/resize.php');

class Uploader {
	private $_local;
	private $_aws;
	private $_rcloud;
	private $_files;
	private $_path;
	private $_ext;
	private $_file_name;
	private $_width;
	private $_height;
	private $_cropped;
	
	public function __construct() {
		global $core;
		extract($core);
		
		$this->_local = $upload['local'];
		$this->_aws = $upload['aws'];
		$this->_rcloud = $upload['rcloud'];
		$this->_path = ROOT."/frontend".$this->_local['path'];
		$this->make_directory($this->_path);
	}
	
	public function upload($files, $dir = "original/") {
		$this->_files = $files;
		if($this->_local['status'] == true) {
			if($dir != "") { $this->make_directory($this->_path."$dir"); }
			foreach($this->_files as $file) {
				$this->_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
				$this->_file_name = md5(time().$file['name']).".$this->_ext";
				if(!copy($file['tmp_name'], $this->_path.$dir.$this->_file_name)) {
					return false;
				} else {
					return $this->_local['path'].$dir.$this->_file_name;
				}
			}
		} elseif($this->_aws['status'] == true) {
			
		}	elseif($this->_rcloud['status'] == true) {

		}
	}
	
	public function make_directory($path) {
		if($this->_local['status'] == true) {
			if(!file_exists($path) && !is_dir($path)) {
				mkdir($path, 0755, true);
			}
		}
	}
	
	public function crop($width, $height, $dir = "", $option='auto', $quality=100) {
		if($this->_local['status'] == true) {
			$file = $this->upload($this->_files, $dir);
			$resize = New Resize(FRONTEND.$file);
			$resize->resizeImage($width, $height, $option);
			$resize->saveImage(FRONTEND.$file, $quality);
			return $file;
		} elseif($this->_aws['status'] == true) {
			
		} elseif($this->_rcloud['status'] == true ) {
			
		}
	}

}