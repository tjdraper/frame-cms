<?php

/**
 * Frame bootstrap
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

// Set up autoloading
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
	$file = FRAME_PATH . DIRECTORY_SEPARATOR . $ns;
	$file = rtrim($file, DIRECTORY_SEPARATOR) . '.php';

	// Check system path for class
	if (file_exists($file)) {
		include_once $file;
		return;
	}

	// Check vendor directory for class
	// $file = FRAME_PATH . DIRECTORY_SEPARATOR . 'Vendor' . DIRECTORY_SEPARATOR . $ns;
	// $file = rtrim($file, DIRECTORY_SEPARATOR) . '.php';

	// if (file_exists($file)) {
	// 	include_once $file;
	// }
});

// Include frame
$frameInstance = new Frame\Frame();

// Set up global access
function frame() {
	return $GLOBALS['frameInstance'];
};

// Run the app
$controller = new Frame\Controller\App();
$controller->run();
