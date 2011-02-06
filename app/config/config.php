<?php
/**
* Config File
*
* Configuration File for your Orchestra Application
* Defined is the basic application settings that need to be adjusted to make the application work correctly.
* Some of the below may not apply to everyone, as that is a general framework for anyone to use.
*
* Licensed under the MIT license.
*
* @category   Orchestra
* @copyright  Copyright (c) 2010, Christopher Hein
* @license    http://orchestramvc.chrishe.in/license
* @version    Release: 0.0.1:beta
* @link       http://orchestramvc.chrishe.in/docs/config/config/
*
*/


/* Global Meta Data
    Basic High level overview of all of the meta data
    to be displayed on all pages carried through the app/view/layout/applcation.php
*/
$display['site_title']  = 'Orchestra';
$display['description'] = 'PHP MVC Framework';
$display['keywords']    = 'these are keywords';
$display['copyright']   = 'Christopher Hein';
$display['author']      = 'Christopher Hein';
$display['contact']     = 'me@chrishe.in';

/* Application Status
    Is the site in ('development', 'test', 'production')
    This sets whether the errors are sent to display or logged 
    If logged all errors are sent to tmp/logs/(respective_log_names).log
*/
$app['status'] = 'development';

/* Site URL 
    This is a security variable to make sure the site has a better security protocal for handling i/o requests
*/
$app['base_path'] = 'http://orchestra.com/';

/* Database Connections
    Definitions of current database for connections through the models
    This is to allow for multiple instances of Orchestra Applications in one database
    Leave this set to 'orc_' if unsure
*/
$app['db_prefix']   = 'orc_';

$app['salt'] = 'orchestra';

$app['pagination'] = '10';

/* Other Settings
    Many plugins require you to add setting information Enter that below.
*/
$app['haml'] = false;

$app['orch-token'] = "aa8c05be452dd32227ec39a89ceeb8fce744ce7d";

$app['cache-time'] = 1;