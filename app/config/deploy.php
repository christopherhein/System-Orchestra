<?php
/**
* Deploy File 
*
* Fill this out with the Git Repo and needed information for the live server and fire using 'php script/deploy'
* In the CMD Line to deploy and back up you site. Variables may be passed into the script
* for server restarts, DB Dumps, DB Refreshing
*
* Licensed under the MIT license.
*
* @category   Orchestra
* @copyright  Copyright (c) 2010, Christopher Hein
* @license    http://orchestramvc.chrishe.in/license
* @version    Release: 0.0.1:beta
* @link       http://orchestramvc.chrishe.in/docs/config/deploy/
*
*/

  // Git Information
$deploy['application'] = 'Repository Name';
$deploy['repository'] = 'Repository URL';

  // SSH Connection
$deploy['user'] = 'user';
$deploy['server'] = 'server';
$deploy['location'] = '/path/';
$deploy['live-url'] = 'http://orchestramvc.com/';
