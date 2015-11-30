<?php

/**
 * Frame Content service
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\Service;

class Content
{
	/**
	 * Get content for the current url
	 *
	 * @param uri
	 * @return string (?)
	 */
	public function get($uri)
	{
		echo 'get content for current url';
		var_dump($uri);
		die;
	}
}
