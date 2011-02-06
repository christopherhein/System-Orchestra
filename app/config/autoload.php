<?php
/**
* Autoload File
*
* Add any files you would like to autoload here
*
* Licensed under the MIT license.
*
* @category   Orchestra
* @copyright  Copyright (c) 2010, Christopher Hein
* @license    http://orchestramvc.chrishe.in/license
* @version    Release: 0.0.1:beta
* @link       http://orchestramvc.chrishe.in/docs/config/autoload/
*
*/

  // Addons
$autoload['addons'] = array(
  "twitter",
  "linkify",
  "disqus",
  "ganalytics"
);

  // Helpers
$autoload['helpers'] = array(
  "application_helper"
);

  // Framework Business
$autoload['framework'] = array(
  "settings",
  "helpers",
  "form",
  "uploader",
  "validate",
  "html",
  "benchmark",
  "cache",
  "http",
  "notice",
  "inflect",
  "paginate",
  "paths",
  "hooks", // Must be the last file
);



  // Require But not initalized
$require['config'] = array(
  "config",
  "mailer",
  "uploader",
  "database",
  "routes",
  "twitter",
  "disqus",
  "ganalytics"
); 
$require['framework'] = array(
  "array_xml",
  "template"
);
$require['controllers'] = array(
  "application_controller"
);
$require['models'] = array(
  "application_model"
);
