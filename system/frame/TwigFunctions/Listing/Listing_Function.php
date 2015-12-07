<?php

/**
 * Frame ExampleFunc twig function
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\TwigFunctions\Listing;

class Listing_Function
{
	/**
	 * Listing
	 *
	 * @param string $listingDirectory
	 * @return string
	 */
	public static function index($listingDirectory)
	{
		return 'Example';
	}
}
