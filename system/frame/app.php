<?php

/**
 * Frame setup file
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */


/*
|--------------------------------------------------------------------------
| Check PHP Requirements
|--------------------------------------------------------------------------
|
| Let's make sure PHP requirements are met before doing anything else
|
*/

if (! defined('PHP_VERSION_ID') or PHP_VERSION_ID < 50400) {
	exit('Frame requires PHP 5.4.0 or later but you&rsquo;re running ' . PHP_VERSION . ' You will need to update PHP to at least 5.4 to run Frame');
}


/*
|--------------------------------------------------------------------------
| Autoloading
|--------------------------------------------------------------------------
|
| Let's set up our class autoloading
|
*/

require 'autoload.php';


/*
|--------------------------------------------------------------------------
| Setup globals
|--------------------------------------------------------------------------
|
| We need some global config items
|
*/

global $sysDir;
global $userDir;

$sysDir = realpath(__DIR__);
$userDir = realpath(__DIR__ . '/../user');


/*
|--------------------------------------------------------------------------
| Run the app
|--------------------------------------------------------------------------
|
| We need to run the app controller which will return a view to the user
|
*/

// Run the app
$controller = new Frame\Controller\App();
$controller->run();
