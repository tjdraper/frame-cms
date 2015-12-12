<?php

/**
 * Frame load file
 *
 * @package Frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */


/*
|--------------------------------------------------------------------------
| User Config
|--------------------------------------------------------------------------
|
| Use the variables below for initial system config
|
*/

// Enable debugging at the earliest possible time. This is true for Frame
// development. Set to false for release.
$debug = true;

// Path to the frame directory
$framePath = '../system';


/*
|--------------------------------------------------------------------------
| System
|--------------------------------------------------------------------------
|
| Do not edit below this block
|
*/

// Enable debug as early as possible if requested
if ($debug) {
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
}

// Based on the $framePath above, set the full frame page
$framePath = rtrim($framePath, '/') . '/frame/app.php';

// If this path is not correct, we need to exit with an error
if (! is_file($framePath)) {
	http_response_code(503);

	exit('Drat! We couldn&rsquo;t find your system directory. Please make sure <strong><code>$framePath</code></strong> is set correctly in ' . __FILE__);
}

// And now we should run the application
require $framePath;
