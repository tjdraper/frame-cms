<?php

/**
 * Frame Cache service
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\Service;

use Frame\Model\Config;
use Frame\Model\Uri;

class Cache
{
	protected $config;
	protected $uri;

	/**
	 * Cache constructor
	 *
	 * @param object $config An instance of the Config model
	 * @param object $uri An instance of the Uri model
	 */
	public function __construct(Config $config, Uri $uri)
	{
		$this->config = $config;
		$this->uri = $uri;
	}

	/**
	 * Write cache file
	 *
	 * @param string $content
	 */
	public function write($content)
	{
		// Make sure cache is enabled
		if (! $this->config->get('enableCache')) {
			return;
		}

		// Set initial cache path the cache path
		$path = rtrim($this->config->get('cachePath'), '/') . '/';

		// Make sure cache path exists
		if (! is_dir($path)) {
			throw new \Exception('No cache directory found');
		}

		$uri = $this->uri->get('segments');
		$page = $this->uri->get('page');

		if ($page > 1) {
			$uri[] = 'page';
			$uri[] = $page;
		}

		// Go through the segments, add them to the path, and write directories
		foreach ($uri as $segment) {
			if ($segment) {
				$path .= $segment . '/';

				if (! is_dir($path)) {
					mkdir($path, 0777);
				}
			}
		}

		// Add index.html to the path
		$path .= 'index.html';

		// Write the cache file contents
		file_put_contents($path, $content);
	}
}
