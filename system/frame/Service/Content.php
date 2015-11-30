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
		$content = $this->checkContent($uri);

		var_dump($content);
	}

	/**
	 * Check paths for content
	 *
	 * @return string Contents of file
	 */
	private function checkContent($uri)
	{
		// Set index if uri is empty
		$uri = $uri ?: 'index';

		// Set the user content path
		$contentPath = USER_PATH . '/content/';

		// Check for a file at the uri location
		$checkPath = $contentPath . $uri . '.md';

		if (is_file($checkPath)) {
			return file_get_contents($checkPath);
		}

		// Check for an index in the uri directory location
		$checkPath = $contentPath . $uri . '/index.md';

		if (is_file($checkPath)) {
			return file_get_contents($checkPath);
		}

		return '';
	}
}
