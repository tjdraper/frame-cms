<?php

/**
 * Frame Example twig filter
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\TwigFilters\Example;

class Example_filter
{
	/**
	 * Example filter
	 *
	 * @return string
	 */
	public static function index($string, $arg1 = false, $arg2 = false)
	{
		return 'Example';
	}
}
