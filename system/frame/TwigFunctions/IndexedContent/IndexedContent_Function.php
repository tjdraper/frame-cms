<?php

/**
 * Frame IndexedContent twig function
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\TwigFunctions\IndexedContent;

use Frame\Service;

class IndexedContent_Function
{
	/**
	 * IndexedContent
	 *
	 * @param array $conf {
	 *     @var string $path
	 *     @var bool $topLevelDirectories
	 * }
	 */
	public static function index($conf)
	{
		$content = new Service\IndexedContent($conf);

		return $content->get();
	}
}
