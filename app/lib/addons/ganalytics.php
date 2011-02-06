<?php
/**
* Google Analytics
*
* The Google Analytics Instrument file
*
* Licensed under the MIT license.
*
* @category   Orchestra
* @copyright  Copyright (c) 2010, Christopher Hein
* @license    http://orchestramvc.chrishe.in/license
* @version    Release: 0.0.1:beta
* @link       http://orchestramvc.chrishe.in/docs/instruments/disqus
*
*/
class Ganalytics {
	protected $_account_id;
	protected $_site;
	
	public function __construct($option = array()) {
	  global $ganalytics;
	  global $app;
	  
		if(isset($option['site'])) {
			extract($option);
			$this->_account_id = $account_id;
			$this->_site = $site;
		} else {
			$this->_account_id = $ganalytics[$app['status']]['account_id'];
  		$this->_site = $ganalytics[$app['status']]['site'];
		}
  }

	public function scripts() {
		$code = "<script type=\"text/javascript\"> 
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '".$this->_account_id."']);
  _gaq.push(['_setDomainName', '.".$this->_site."']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>";
		return $code;
	}
	
}