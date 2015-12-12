<?php

/**
 * Frame app controller
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\Controller;

use Frame\Model;
use Frame\Helper;

class App
{
	/**
	 * Run the app
	 */
	public function run()
	{
		// Get debug settings
		$config = new Model\Config();
		$debug = $config->get('debug');

		// Turn on all error reporting if config calls for it
		if ($debug === true) {
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL);
		}

		// Get all composer autoloads in vendor directory
		Helper\VendorComposer::setup();

		// Get the Uri
		$uri = new Model\Uri();

		var_dump($uri->get());
		die;
	}
}
