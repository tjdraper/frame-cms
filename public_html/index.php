<?php

/**
 * Frame load file
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Path to the frame/ directory
$framePath = '../system';

/*------------------------------------*\
	# System Config, do not edit
\*------------------------------------*/

$framePath = rtrim($framePath, '/') . '/frame/index.php';

if (! is_file($framePath)) {
	http_response_code(503);

	exit('Drat! We couldn&rsquo;t find your system directory. Please make sure <strong><code>$framePath</code></strong> is set correctly in ' . __FILE__);
}

require_once $framePath;
