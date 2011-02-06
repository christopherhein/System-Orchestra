<?php
/**
* Uploader File 
*
* Global Settings for Uploader
*
* Licensed under the MIT license.
*
* @category   Orchestra
* @copyright  Copyright (c) 2010, Christopher Hein
* @license    http://orchestramvc.chrishe.in/license
* @version    Release: 0.0.1:beta
* @link       http://orchestramvc.chrishe.in/docs/config/uploader/
*
*/

  // Local Information
$upload['local']['status'] = true;
$upload['local']['path'] = "/images/";

	// Amazon AWS
$upload['aws']['status'] = false;
$upload['aws']['key'] = '';
$upload['aws']['secret_key'] = '';
$upload['aws']['account_id'] = '';
$upload['aws']['canonical_id'] = '';
$upload['aws']['canonical_name'] = '';
$upload['aws']['mfa_serial'] = '';
$upload['aws']['cloudfront_repair_id'] = '';
$upload['aws']['cloudfront_private_key_pem'] = '';
$upload['aws']['enable_extensions'] = '';

	// RackSpace CloudFiles
$upload['rcloud']['status'] = false;
$upload['rcloud']['verbose'] = false;
$upload['rcloud']['user'] = '';
$upload['rcloud']['key'] = '';
$upload['rcloud']['account'] = '';
$upload['rcloud']['host'] = '';