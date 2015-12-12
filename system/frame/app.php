<?php

/**
 * Frame setup file
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

// Make sure this is PHP 5.4 or later
if (! defined('PHP_VERSION_ID') or PHP_VERSION_ID < 50400) {
	exit('Frame requires PHP 5.4.0 or later but you&rsquo;re running ' . PHP_VERSION . ' You will need to update PHP to at least 5.4 to run Frame');
}

/**
 * Set path constants
 */

// Get the current script path as an array
$currentPath = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));

// Go to the end of the array
end($currentPath);

// Unset the last directory so we have the system path one level back
unset($currentPath[key($currentPath)]);

// Put the path back together
$currentPath = implode(DIRECTORY_SEPARATOR, $currentPath);

// Set APP_PATH
define('APP_PATH', $currentPath);

// Set FRAME_PATH
define('FRAME_PATH', APP_PATH . '/frame');

// Set USER_PATH
define('USER_PATH', APP_PATH . '/user');

/**
 * Run the app
 */

// Require Frame bootstrap file
require_once 'Bootstrap.php';
