<?php
/**
* Disqus
*
* The Disqus Instrument file
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
class Disqus {
	protected $_id;
	protected $_site;
	protected $_developer;
	protected $_show_tags;
	
	public function __construct($option = array()) {
	  global $disqus;
	  global $app;
	  
		$this->_id = $disqus[$app['status']]['id'];
		$this->_site = $disqus[$app['status']]['site'];
		$this->_developer = $disqus[$app['status']]['developer'];
		$this->_show_tags = $disqus[$app['status']]['show_tags'];
  }

	public function comments() {
		$code = "<div id=\"disqus_thread\"></div>
<script type=\"text/javascript\">
  var disqus_developer = ".$this->_developer.";
  (function() {
   var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
   dsq.src = 'http://".$this->_site.".disqus.com/embed.js';
   (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
  })();
</script>
<noscript>Please enable JavaScript to view the</noscript>";
		if($this->_show_tags) {
			$code .= "<a href=\"http://disqus.com\" class=\"dsq-brlink\">blog comments powered by <span class=\"logo-disqus\">Disqus</span></a>";
		}
		return $code;
	}
	
	public function scripts() {
		$code = "<script type=\"text/javascript\">
var disqus_shortname = '".$this->_site."';
(function () {
  var s = document.createElement('script'); s.async = true;
  s.src = 'http://disqus.com/forums/".$this->_site."/count.js';
  (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
}());
</script>";
		return $code;
	}
	
}