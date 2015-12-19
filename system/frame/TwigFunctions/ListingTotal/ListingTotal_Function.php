<?php

/**
 * Frame ListingTotal twig function
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\TwigFunctions\ListingTotal;

use Frame\Service;

class ListingTotal_Function
{
	/**
	 * ListingTotal
	 *
	 * @param array $conf {
	 *     @var string $path
	 *     @var int $offset
	 * }
	 * @return array
	 */
	public static function index($conf = [])
	{
		$listingTotal = new Service\ListingTotal($conf);

		return $listingTotal->get();
	}
}
