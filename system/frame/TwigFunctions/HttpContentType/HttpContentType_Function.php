<?php

/**
 * Frame HttpContentType twig function
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\TwigFunctions\HttpContentType;

class HttpContentType_Function
{
	/**
	 * Set Content Type
	 *
	 * @param array $conf
	 */
	public static function index($conf)
	{
		// Make sure we have a value to set
		if (! isset($conf['value'])) {
			return;
		}

		header("Content-type: {$conf['value']}");
	}
}
