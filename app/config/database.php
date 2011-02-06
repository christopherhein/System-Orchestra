<?php
/**
* Database File
*
* Add your database connections whether they're SQLite, MongoDB, MySQL for each Development, Testing and Production
*
* Licensed under the MIT license.
*
* @category   Orchestra
* @copyright  Copyright (c) 2010, Christopher Hein
* @license    http://orchestramvc.chrishe.in/license
* @version    Release: 0.0.1:beta
* @link       http://orchestramvc.chrishe.in/docs/config/database/
*
*/

  // Developemt Environment Connections
$db['development'] = array(
	'type' 			=> 'mysql',
	'server'		=> 'localhost',
	'user'			=> 'root',
	'password'	=> 'root',
	'name'			=> 'orchestra_development'
);

$db['test'] = array(
	'type' 			=> 'mysql',
	'server'		=> 'localhost',
	'user'			=> 'root',
	'password'	=> 'root',
	'name'			=> 'orchestra_test'
);

$db['production'] = array(
	'type' 			=> 'mysql',
	'server'		=> 'localhost',
	'user'			=> 'root',
	'password'	=> 'root',
	'name'			=> 'orchestra_production'
);