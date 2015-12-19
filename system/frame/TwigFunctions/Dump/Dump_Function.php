<?php

/**
 * Frame Dump twig function
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\TwigFunctions\Dump;

class Dump_Function
{
	/**
	 * Dump
	 *
	 * @param mixed $item
	 * @param bool $die Optional
	 */
	public static function index($item, $die = false)
	{
		var_dump($item);

		if ($die) {
			die;
		}
	}
}
