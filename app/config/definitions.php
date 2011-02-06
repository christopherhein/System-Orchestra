<?php
/**
* Definitions File
*
* Globally Accepted Definitions throughout Orchestra are defined here
*
* Licensed under the MIT license.
*
* @category   Orchestra
* @copyright  Copyright (c) 2010, Christopher Hein
* @license    http://orchestramvc.chrishe.in/license
* @version    Release: 0.0.1:beta
* @link       http://orchestramvc.chrishe.in/docs/config/definitions/
*
*/

  // We've started by defining the DS and ROOT which is also needed to be repeated in the public/index.php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

  // Directory Definitions
define('APP', ROOT.DS.'app'.DS);
define('CONTROLLERS', APP.'controllers'.DS);
define('HELPERS', APP.'helpers'.DS);
define('MODELS', APP.'models'.DS);
define('VIEWS', APP.'views'.DS);
define('CONFIG', ROOT.DS.'config'.DS);
define('DB', ROOT.DS.'db'.DS);
define('LIB', ROOT.DS.'lib'.DS);
define('ADDONS', LIB.'addons'.DS);
define('DRIVERS', LIB.'drivers'.DS);
define('FRAMEWORK', LIB.'framework'.DS);
define('INSTRUMENTS', ROOT.DS.'instruments'.DS);
define('FRONTEND', ROOT.DS.'frontend'.DS);
define('SCRIPTS', ROOT.DS.'scripts'.DS);
define('TEST', ROOT.DS.'test'.DS);
define('TMP', ROOT.DS.'tmp'.DS);
define('CACHE', TMP.'cache'.DS);
define('LOGS', TMP.'logs'.DS);
define('HAML', TMP.'haml'.DS);
define('SESSIONS', TMP.'sessions'.DS);