<?php

/**
 * Frame AddTwigGlobals
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\Helper;

class TwigGlobals
{
	/**
	 * Add user globals and any passed in globals to Twig Environment
	 *
	 * @param object $twigEnv
	 * @param array $globals Optional
	 */
	public static function add($twigEnv, $globals = [])
	{
		global $userDir;

		$globalsPath = $userDir . '/globals/';

		// Get user globals
		$globalConfigFiles = DirArray::files($globalsPath);

		// Add them to Twig
		foreach ($globalConfigFiles as $file) {
			$fileGlobals = require $globalsPath . $file;

			foreach ($fileGlobals as $key => $global) {
				$twigEnv->get()->addGlobal($key, $global);
			}
		}

		// Add argument globals to twig
		foreach ($globals as $key => $global) {
			$twigEnv->get()->addGlobal($key, $global);
		}
	}
}
