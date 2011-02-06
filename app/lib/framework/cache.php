<?php
/**
* Application Cache
*
* Global Cache
*
* Licensed under the MIT license.
*
* @category   Orchestra
* @copyright  Copyright (c) 2010, Christopher Hein
* @license    http://orchestramvc.chrishe.in/license
* @version    Release: 0.0.1:beta
* @link       http://orchestramvc.chrishe.in/docs/lib/framework/cache/
*
*/
class Cache {
	protected $_cache_file;
	protected $_cache_time;
	protected $_dev;

	public function __construct($time = 1) {
	  global $app;
	  if($app['cache-time'] != 1) {
	    $time = $app['cache-time'];
	  }
		$this->_cache_time = $time * 60;
	}
	
	public function start($dev = false) {
		global $url;
		global $app;
		$this->_dev = $dev;
		if($app['status'] == 'production' || $this->_dev == true) {
			$this->_cache_file = CACHE.md5($app['base_path'].$url);
			if (file_exists($this->_cache_file) && (time() - $this->_cache_time < filemtime($this->_cache_file))) {
				include($this->_cache_file);
				echo "\n<!-- Cached ".date('H:i', filemtime($this->_cache_file))." -->\n";
				exit;
			}
			ob_start();
		}
	}
	
	public function end() {
		global $app;
		if($app['status'] == 'production' || $this->_dev == true) {
			$open = fopen($this->_cache_file, 'w');
			fwrite($open, ob_get_contents());
			fclose($open);
			ob_end_flush();
		}
	}
	
	public function clear() {
		exec("rm -rf ".CACHE." ; mkdir ".CACHE." ; chmod -R 777 ".CACHE." ;");
		return true;
	}

}