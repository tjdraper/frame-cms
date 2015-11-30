<?php

/**
 * Frame
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\Service;

class Config
{
	/**
	 * Set config from files
	 */
	public function setFromFiles()
	{
		$config = include_once FRAME_PATH . '/Config/DefaultConfig.php';

		if (is_file(USER_PATH . '/config/config.php')) {
			$userConfig = include_once USER_PATH . '/config/config.php';

			$config = array_merge($config, $userConfig);
		}

		foreach ($config as $key => $val) {
			frame()->setConfig($key, $val);
		}

		if (isset($config['debug']) and $config['debug'] === true) {
			$this->turnOnErrors();
		}
	}

	/**
	 * Turn on error reporting
	 */
	private function turnOnErrors()
	{
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
	}
}
