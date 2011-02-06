<?php
/**
* Application Benchmarking
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
class Benchmark {
	protected $_start;
	protected $_end;

	public function start() {
		$this->_start = $this->get_time();
	}
	
	public function end() {
		$this->_end = $this->get_time();
		$speed = round($this->_end - $this->_start, 4);
		return $speed;
	}
	
	public function get_time() {
		$timer = explode( ' ', microtime() ); 
		$timer = $timer[1] + $timer[0]; 
		return $timer;
	}

}