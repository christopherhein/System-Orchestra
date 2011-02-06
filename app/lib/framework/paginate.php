<?php
/**
* Application Pagination
*
* Global notice
*
* Licensed under the MIT license.
*
* @category   Orchestra
* @copyright  Copyright (c) 2010, Christopher Hein
* @license    http://orchestramvc.chrishe.in/license
* @version    Release: 0.0.1:beta
* @link       http://orchestramvc.chrishe.in/docs/lib/framework/paginate/
*
*/
class Paginate {
  private $_app = array(); 
  private $_pg_num;
  private $_url;
  private $_build;
  private $_links = "";
  private $_num_pages;
  
	public function __construct() {
    global $app;
    global $page_num;
    global $url;
    
    $this->_app = $app;
    $this->_url = $url;
    if(!isset($page_num) && $page_num == "") {
      $this->_pg_num = 1;
    } else {
      $this->_pg_num = $page_num;
    }
	}
	
	public function build($num) {
	  $this->_num_pages = ceil($num/$this->_app['pagination']);
	  for($i = 1; $i < $this->_num_pages+1; $i++) {
	    if($i == $this->_pg_num) {
	      $this->_links .= "<span class='current'>$i</span>";
	    } else {
	      $this->_links .= "<a href='".$this->_app['base_path'].$this->_url."?p=".$i."'>$i</a>"; 
	    }
	  }
	}
	
	public function show() {
	  $prev = $this->_pg_num - 1;
	  $next = $this->_pg_num + 1;
	  $pagination = "<div id='pagination'>";
	  if($this->_pg_num == 1) {
	    $pagination .= "<span class='disabled'>Prev</span>";
    } else {
	    $pagination .= "<a href='".$this->_app['base_path'].$this->_url."?p=".$prev."'>Prev</a>"; 
	  }
	  $pagination .= $this->_links;
	  if($this->_pg_num == $this->_num_pages) {
	    $pagination .= "<span class='disabled'>Next</span>";
    } else {
	    $pagination .= "<a href='".$this->_app['base_path'].$this->_url."?p=".$next."'>Next</a>"; 
	  }
	  $pagination .= "</div>";
	  return $pagination;
	}
	
}