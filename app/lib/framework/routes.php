<?php
/**
* Routing File
*
* Routing File for methods used for routes helpers
*
* Licensed under the MIT license.
*
* @category   Orchestra
* @copyright  Copyright (c) 2010, Christopher Hein
* @license    http://orchestramvc.chrishe.in/license
* @version    Release: 0.0.1:beta
* @link       http://orchestramvc.chrishe.in/docs/lib/framework/routes/
*
*/

function resource($controller, $id = 'NULL') {
  global $pages;
  $pages["$controller"] = array( 
  	 'url'         	=> "/$controller/index", 
  	 'controller'		=> "$controller", 
  	 'action'      	=> 'index', 
  ); 
  
  $pages["$controller/"] = array( 
  	 'url'         	=> "/$controller/index", 
  	 'controller'		=> "$controller", 
  	 'action'      	=> 'index', 
  );

  $pages["$controller/$id"] = array( 
  	 'url'         	=> "/$controller/show", 
  	 'controller'		=> "$controller", 
  	 'action'      	=> 'show', 
  ); 

  $pages["$controller/new"] = array(
  	 'url'         	=> "/$controller/new_item", 
  	 'controller'		=> "$controller", 
  	 'action'      	=> 'new_item',
  );
  
  $pages["$controller/new/"] = array(
  	 'url'         	=> "/$controller/new_item", 
  	 'controller'		=> "$controller", 
  	 'action'      	=> 'new_item',
  );

  $pages["$controller/create"] = array( 
  	 'url'         	=> "/$controller/create", 
  	 'controller'		=> "$controller", 
  	 'action'      	=> 'create', 
  ); 

  $pages["$controller/$id/edit"] = array( 
  	 'url'         	=> "/$controller/edit", 
  	 'controller'		=> "$controller", 
  	 'action'      	=> 'edit', 
  ); 

  $pages["$controller/update"] = array( 
  	 'url'         	=> "/$controller/update", 
  	 'controller'		=> "$controller", 
  	 'action'      	=> 'update', 
  );

  $pages["$controller/$id/destroy"] = array( 
  	 'url'         	=> "/$controller/destroy", 
  	 'controller'		=> "$controller", 
  	 'action'      	=> 'destroy', 
  );

}