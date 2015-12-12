<?php

/**
 * Frame autoloading
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */


/*
|--------------------------------------------------------------------------
| Base autoloading
|--------------------------------------------------------------------------
|
| This will autoload Frame base classes
|
*/

spl_autoload_register(function ($class) {
	// Get an array of the namespace being called
	$ns = explode('\\', $class);

	// Unset the first segment
	unset($ns[0]);

	// Put the file path together
	$ns = implode(DIRECTORY_SEPARATOR, $ns);

	// Make sure there is no trailing slash
	rtrim($ns, '/');

	// Set the file name
	$file = __DIR__ . DIRECTORY_SEPARATOR . $ns;
	$file = rtrim($file, DIRECTORY_SEPARATOR) . '.php';

	// Check for the file
	if (file_exists($file)) {
		include_once $file;
	}
});
