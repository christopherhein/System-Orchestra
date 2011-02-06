<?php
/**
* Mailer File
*
* Add your Mailer Connections in here.
*
* Licensed under the MIT license.
*
* @category   Orchestra
* @copyright  Copyright (c) 2010, Christopher Hein
* @license    http://orchestramvc.chrishe.in/license
* @version    Release: 0.0.1:beta
* @link       http://orchestramvc.chrishe.in/docs/config/mailer/
*
*/

  // Developemt Environment Connections
$mail['development'] = array(
	'name'						=> 'Your Name',
	'address'					=> 'smtp.example.com',
	'port'						=> 587,
	'domain'					=> 'Domain',
	'authentication'	=> 'plain',
	'user_name'				=> 'Email Address',
	'password'				=> 'Password'
);

$mail['test'] = array(
	'name'						=> 'Your Name',
	'address'					=> 'smtp.example.com',
	'port'						=> 587,
	'domain'					=> 'Domain',
	'authentication'	=> 'plain',
	'user_name'				=> 'Email Address',
	'password'				=> 'Password'
);

$mail['production'] = array(
	'name'						=> 'Your Name',
	'address'					=> 'smtp.example.com',
	'port'						=> 587,
	'domain'					=> 'Domain',
	'authentication'	=> 'plain',
	'user_name'				=> 'Email Address',
	'password'				=> 'Password'
);