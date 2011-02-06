<?php
/**
* Twitter
*
* The Twiter Instrument file
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
require_once(dirname(dirname(__FILE__)).'/framework/oauth.php');

class Twitter {
  private $_username;
  private $_password;
  private $_feed_amount;
  private $_api_key;
  private $_callback_url;
  private $_consumer_key;
  private $_consumer_secret;
  private $_host = "https://api.twitter.com/1/";
  private $_sha1_method;
  private $_consumer;
  private $_token;
  private $_oauth_token;
  private $_oauth_token_secret;
  private $_timeout = 60;
  public $_http_code;
  private $_http_info;
  private $_useragent;
  private $_url;
  private $_return;
  
	public function __construct() {
	  global $twitter;
	  global $app;
	  
	  $this->_username = $twitter[$app['status']]['username'];
	  $this->_password = $twitter[$app['status']]['password'];
	  $this->_feed_amount = $twitter[$app['status']]['feed_amount'];
	  $this->_api_key = $twitter[$app['status']]['api_key'];
	  $this->_callback_url = $twitter[$app['status']]['callback_url'];
	  $this->_consumer_key = $twitter[$app['status']]['consumer_key'];
	  $this->_consumer_secret = $twitter[$app['status']]['consumer_secret'];
	  if(isset($_SESSION['oauth_token'])) { $this->_oauth_token = $_SESSION['oauth_token']; }
	  if(isset($_SESSION['oauth_token_secret'])) { $this->_oauth_token_secret = $_SESSION['oauth_token_secret']; }
	  if(isset($_SESSION['oauth_token']) && isset($_SESSION['oauth_token_secret'])) { $this->build_oauth(); }
  }
  
  public function anywhere() {
    $this->format_url("anywhere");
    $this->_return = "<script src=\"$this->_url\" type=\"text/javascript\"></script>";
    return $this->_return;
    $this->clear();
  }
  
  public function share($options = array()) {
    $this->format_url("share");
    $this->_return = "<a href=\"$this->_url\" class=\"twitter-share-button\" ";
    if($options != array()) {
      foreach($options as $key => $value) {
        $this->_return .= "data-$key=\"$value\" ";
      }
    }
    $this->_return .= ">Tweet</a>";
    return $this->_return;
    $this->clear();
  }
  
  public function signin() {
    $this->build_oauth();
    $this->oauth_tokens();
    
    switch ($this->_http_code) {
      case 200:
        $url = $this->authorize_url($this->_oauth_token);
        header('Location: ' . $url); 
      break;
      default:
        echo 'Could not connect to Twitter. Refresh the page or try again later.';
    }
  }
  
  public function signout() {
    session_destroy();
  }
  
  public function authorize() {
    if(isset($_SESSION['oauth_token']) && isset($_SESSION['oauth_token_secret']) && isset($_SESSION['access_token'])) {
      return true;
    } else {
      return false;
    }
  }
  
  public function get($url, $parameters = array()) {
    $response = $this->oauth_request($url, 'GET', $parameters);
    return json_decode($response);
  }
  
  function authorize_url($token, $sign_in_with_twitter = TRUE) {
    if (is_array($token)) {
      $token = $token['oauth_token'];
    }
    if (empty($sign_in_with_twitter)) {
      return $this->format_url("authorize")."?oauth_token={$token}";
    } else {
       return $this->format_url("authenticate")."?oauth_token={$token}";
    }
  }
  
  public function feed($options = array()) {
    if($options != array()) {
      if(isset($options['username'])) { $this->_username = $options['username']; }
      if(isset($options['count'])) { $this->_feed_amount = $options['count']; }
    }
    $this->format_url();
    $this->_return = "";
		$c = curl_init();
		curl_setopt_array($c, array(
			CURLOPT_URL => $this->_url,
			CURLOPT_HEADER => false,
			CURLOPT_TIMEOUT => 10,
			CURLOPT_RETURNTRANSFER => true
		));
		$this->_return = curl_exec($c);
		curl_close($c);
  	return (!!$this->_return ? json_decode($this->_return, true) : false);
    $this->clear();
  }
  
  private function format_url($type = "feed") {
    switch($type) {
      case "feed":
        return $this->_url = "http://twitter.com/statuses/user_timeline/$this->_username.json?count=$this->_feed_amount";
      break;
      case "access_token":
        return $this->_url = "https://api.twitter.com/oauth/access_token";
      break;
      case "authenticate":
        return $this->_url = "https://twitter.com/oauth/authenticate";
      break;
      case "authorize":
        return $this->_url = "https://twitter.com/oauth/authorize";
      break;
      case "request_token":
        return $this->_url = "https://api.twitter.com/oauth/request_token";
      break;
      case "anywhere":
        return $this->_url = "http://platform.twitter.com/widgets.js";
      break;
      case "share":
        return $this->_url = "http://twitter.com/share";
      break;
    }
  }
  
  private function build_oauth() {
    $this->_sha1_method = new OAuthSignatureMethod_HMAC_SHA1();
    $this->_consumer = new OAuthConsumer($this->_consumer_key, $this->_consumer_secret);
    if(!empty($this->_oauth_token) && !empty($this->_oauth_token_secret)) {
      $this->_token = new OAuthConsumer($this->_oauth_token, $this->_oauth_token_secret);
    } else {
      $this->_token = NULL;
    }
  }
  
  private function oauth_tokens() {
    $parameters = array();
    if (!empty($this->_callback_url)) {
      $parameters['oauth_callback'] = $this->_callback_url;
    } 
    $request = $this->oauth_request($this->format_url("request_token"), 'GET', $parameters);
    $token = OAuthUtil::parse_parameters($request);
    $this->_token = new OAuthConsumer($token['oauth_token'], $token['oauth_token_secret']);
    $_SESSION['oauth_token'] = $this->_oauth_token = $token['oauth_token'];
    $_SESSION['oauth_token_secret'] = $this->oauth_token_secret = $token['oauth_token_secret'];
  }
  
  public function access_token($oauth_verifier = FALSE) {
    $parameters = array();
    if (!empty($oauth_verifier)) {
      $parameters['oauth_verifier'] = $oauth_verifier;
    } else {
      $parameters['oauth_verifier'] = $_REQUEST['oauth_verifier'];
    }
    $request = $this->oauth_request($this->format_url("access_token"), 'GET', $parameters);
    $token = OAuthUtil::parse_parameters($request);
    $this->token = new OAuthConsumer($token['oauth_token'], $token['oauth_token_secret']);
    $_SESSION['access_token'] = $token;
    return $token;
  }
  
  private function oauth_request($url, $method, $parameters) {
    if (strrpos($url, 'https://') !== 0 && strrpos($url, 'http://') !== 0) {
      $url = "{$this->_host}{$url}.json";
    }
    $request = OAuthRequest::from_consumer_and_token($this->_consumer, $this->_token, $method, $url, $parameters);
    $request->sign_request($this->_sha1_method, $this->_consumer, $this->_token);
    switch ($method) {
      case 'GET':
        return $this->http($request->to_url(), 'GET');
      break;
      default:
        return $this->http($request->get_normalized_http_url(), $method, $request->to_postdata());
    }
  }
  
  private function http($url, $method, $postfields = NULL) {
    $this->_http_info = array();
    $ci = curl_init();
    /* Curl settings */
    curl_setopt($ci, CURLOPT_USERAGENT, $this->_useragent);
    curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, $this->_timeout);
    curl_setopt($ci, CURLOPT_TIMEOUT, $this->_timeout);
    curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ci, CURLOPT_HTTPHEADER, array('Expect:'));
    curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ci, CURLOPT_HEADERFUNCTION, array($this, 'getHeader'));
    curl_setopt($ci, CURLOPT_HEADER, FALSE);

    switch ($method) {
      case 'POST':
        curl_setopt($ci, CURLOPT_POST, TRUE);
        if (!empty($postfields)) {
          curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
        }
        break;
      case 'DELETE':
        curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
        if (!empty($postfields)) {
          $url = "{$url}?{$postfields}";
        }
    }

    curl_setopt($ci, CURLOPT_URL, $url);
    $response = curl_exec($ci);
    $this->_http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
    $this->_http_info = array_merge($this->_http_info, curl_getinfo($ci));
    $this->_url = $url;
    curl_close ($ci);
    return $response;
  }
  
  private function getHeader($ch, $header) {
    $i = strpos($header, ':');
    if (!empty($i)) {
      $key = str_replace('-', '_', strtolower(substr($header, 0, $i)));
      $value = trim(substr($header, $i + 2));
      $this->http_header[$key] = $value;
    }
    return strlen($header);
  }
  
  private function clear() {
    $this->_url = NULL;
    $this->_return = NULL;
    $this->_http_code = NULL;
  }
	
}