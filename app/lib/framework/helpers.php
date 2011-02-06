<?php
/**
* Application Helpers
*
* Any Global helpers
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
class Helpers {
	
  public function __construct() {
	
  }

  public function meta_orch() {
    global $app;
    $_SESSION['orch-token'] = md5($app['db_prefix'].''.$app['base_path'].$_SERVER['REMOTE_ADDR']);
    $meta = "<meta name='orch-param' content='authenticity_token'/> \n";
    $meta .= "<meta name='orch-token' content='".$_SESSION['orch-token']."'/> \n\n";
    return $meta;
  }
	
	public function meta_tags($pg_title = NULL, $separator = '::') {
		global $display;
		$meta = "<meta http-equiv='Content-type' content='text/html; charset=utf-8'> \n";
		if($pg_title != NULL) {
			$meta .= "  <title>".$display['site_title']." ".$separator." ".$pg_title."</title> \n";
		} else {
			$meta .= "<title>".$display['site_title']."</title> \n";
		}
		$meta .= "<meta name='description' content='".$display['description']."'> \n";
		$meta .= "<meta name='keywords' content='".$display['keywords']."'> \n";
		$meta .= "<meta name='copyright' content='".$display['copyright']."'> \n";
		$meta .= "<meta name='author' content='".$display['author']."'> \n";
		$meta .= "<meta name='email' content='".$display['contact']."'> \n";
		$meta .= "<meta name='Charset' content='UTF-8'> \n";
		$meta .= "<meta name='Distribution' content='Global'> \n";
		$meta .= "<meta name='Rating' content='General'> \n";
		$meta .= "<meta name='Robots' content='INDEX,FOLLOW'> \n";
		return $meta;
	}
	
	public function RedirectTo( $page ) {
		echo '<script type="text/javascript">'.
			 'window.location = "'.$page.'"'.
			 '</script>';
	}
  
	public function create_file($file, $data = "", $mode = "x+") {
		$f = ROOT.DS.$file;
		if(!file_exists($f)) {
			$fopen = fopen($f, $mode);
			$fdata = $data;
			$fwrite = fwrite($fopen, $fdata);
			$fclose = fclose($fopen);
			return true;
		}
		return true;
	}
	
	public function currancy($int) {
		$price = "$";
		$dollars = substr($int, 0, -2);
		$cents = substr($int, -2);
		$price .= "$dollars.$cents";
		return $price;
	}
	
	public function encode_email($e) {
    for ($i = 0; $i < strlen($e); $i++) { 
      $output .= '&#'.ord($e[$i]).';'; 
    }
    return $output;
  }
  
  public function properize($string) {
    return $string.'\''.($string[strlen($string) - 1] != 's' ? 's' : '');
  }
	
	public function shorten_urls($data) {
		$data = preg_replace_callback('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', array(get_class($this), '_fetchTinyUrl'), $data);
		return $data;
	}

	private function _fetchTinyUrl($url) { 
		$ch = curl_init(); 
		$timeout = 5; 
		curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/create.php?url='.$url[0]); 
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout); 
		$data = curl_exec($ch); 
		curl_close($ch); 
		return '<a href="'.$data.'" target = "_blank" >'.$data.'</a>'; 
	}

}