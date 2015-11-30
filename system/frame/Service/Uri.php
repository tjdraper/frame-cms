<?php

/**
 * Frame Uri service
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\Service;

class Uri
{
	/**
	 * Set URI values
	 */
	public function set()
	{
		// Get the uri parts
		$uriParts = parse_url($_SERVER['REQUEST_URI']);

		// Get the uri segments
		$uriSegments = explode('/', ltrim($uriParts['path'], '/'));

		$startingSegment = false;

		// Loop through to find a .php segment
		foreach ($uriSegments as $key => $val) {
			if (strpos($val, '.php')) {
				$startingSegment = $key;

				break;
			}
		}

		// Remove any segment before and up to $startingSegment
		if ($startingSegment !== false) {
			foreach ($uriSegments as $key => $val) {
				unset($uriSegments[$key]);

				if ($key === $startingSegment) {
					break;
				}
			}
		}

		// Set the app uri rawPath
		frame()->setUri('rawPath', $uriParts['path']);

		// Set the app uri segments
		frame()->setUri('segments', array_values($uriSegments));

		// Set the app uri path
		frame()->setUri('uriPath', implode('/', $uriSegments));

		// Set the query string if it exists
		if (isset($uriParts['query'])) {
			frame()->seturi('query', $uriParts['query']);
		}
	}
}
