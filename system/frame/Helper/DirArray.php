<?php

/**
 * Frame DirArray
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\Helper;

class DirArray
{
	/**
	 * Get directory array of all items
	 *
	 * @param string $path
	 * @return array
	 */
	public static function all($path)
	{
		$path = rtrim($path, '/') . '/';

		return DirArray::get($path);
	}

	/**
	 * Get files in a directory
	 *
	 * @param string $path
	 * @return array
	 */
	public static function files($path)
	{
		$path = rtrim($path, '/') . '/';

		$content = DirArray::get($path);

		$returnContent = [];

		foreach ($content as $item) {
			if (file_exists($path . $item)) {
				$returnContent[] = $item;
			}
		}

		return $returnContent;
	}

	/**
	 * Get directories from a directory
	 *
	 * @param string $path
	 * @return array
	 */
	public static function directories($path)
	{
		$path = rtrim($path, '/') . '/';

		$content = DirArray::get($path);

		$returnContent = [];

		foreach ($content as $item) {
			if (is_dir($path . $item)) {
				$returnContent[] = $item;
			}
		}

		return $returnContent;
	}

	/**
	 * Get
	 *
	 * @param string $path
	 */
	private static function get($path)
	{
		// Make sure is directory
		if (! is_dir($path)) {
			return [];
		}

		// Get array of directory contents
		$contents = scandir($path);

		// Unset the . and ..
		unset($contents[0]);
		unset($contents[1]);

		$returnContent = [];

		// Make sure there are no hidden files here
		foreach ($contents as $content) {
			if (strpos($content, '.') !== 0) {
				$returnContent[] = $content;
			}
		}

		return array_values($returnContent);
	}
}
