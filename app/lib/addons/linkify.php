<?php
/**
* Linkify
*
* The Linkify Instrument file
*
* Licensed under the MIT license.
*
* @category   Orchestra
* @copyright  Copyright (c) 2010, Christopher Hein
* @license    http://orchestramvc.chrishe.in/license
* @version    Release: 0.0.1:beta
* @link       http://orchestramvc.chrishe.in/docs/instruments/twitter
*
*/
class Linkify {
	protected $_text;
  protected $_options = array();

	public function __construct() {
	
	}

	public function text($text, $options = array('links' => true, 'twitter' => true)) {
		$this->_text = $text;
		$this->_options = $options;
		if(isset($options['links']) && isset($options['twitter'])) {
			$link = $this->links($text);
			$return = $this->twitter($link);
		} else if(isset($options['twitter'])) {
			$return = $this->twitter($text);
		} else if(isset($options['links'])) {
			$return = $this->links($text);
		}
		return $return;
	}
	
	public function links($text) {
		$text= preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\" >$3</a>", $text);
		$text= preg_replace("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"http://$3\" >$3</a>", $text);
		$text= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"mailto:$2@$3\">$2@$3</a>", $text);
		return($text);
	}
	
	public function twitter($text) {
		$text= preg_replace("/@(\w+)/", '<a href="http://www.twitter.com/$1" target="_blank">@$1</a>', $text);
    $text= preg_replace("/\#(\w+)/", '<a href="http://search.twitter.com/search?q=$1" target="_blank">#$1</a>',$text);
    return $text;
	}
	
}