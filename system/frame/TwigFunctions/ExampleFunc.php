<?php

/**
 * Frame ExampleFunc twig function
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\TwigFunctions;

class ExampleFunc
{
	/**
	 * ToString filter
	 *
	 * @return string
	 */
	public static function index($arg1 = false, $arg2 = false)
	{
		return 'Example';
	}
}
