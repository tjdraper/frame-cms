<?php

/**
 * Frame Content twig function
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\TwigFunctions\Content;

use Frame\Model\Content;

class Content_Function
{
	/**
	 * Content
	 *
	 * @param string $path
	 */
	public static function index($path)
	{
		$content = new Content($path);

		return $content->asArray();
	}
}
