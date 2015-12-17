<?php

/**
 * Frame Listing twig function
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\TwigFunctions\Listing;

use Frame\Service;

class Listing_Function
{
	/**
	 * Listing
	 *
	 * @param array $conf {
	 *     @var string $path
	 *     @var int $limit
	 *     @var string $orderBy
	 *     @var string $sort
	 * }
	 * @return array
	 */
	public static function index($conf = [])
	{
		$listing = new Service\Listing($conf);

		return $listing->get();
	}
}
