<?php
/**
* Disqus File
*
* Add your Disqus Connections in here.
*
* Licensed under the MIT license.
*
* @category   Orchestra
* @copyright  Copyright (c) 2010, Christopher Hein
* @license    http://orchestramvc.chrishe.in/license
* @version    Release: 0.0.1:beta
* @link       http://orchestramvc.chrishe.in/docs/addons/disqus/
*
*/

$disqus['development'] = array(
  'id' => 'disqus',
  'site' => 'disqus-sitename',
  'developer' => 1, 
  'show_tags' => false
);

$disqus['test'] = array(
  'id' => 'disqus',
  'site' => 'disqus-sitename',
  'developer' => 1, 
  'show_tags' => false
);

$disqus['production'] = array(
  'id' => 'disqus',
  'site' => 'disqus-sitename',
  'developer' => 0, 
  'show_tags' => false
);