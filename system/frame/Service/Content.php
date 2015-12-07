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

use Mni\FrontYAML;

class Content
{
	/**
	 * Get content for the current url
	 *
	 * @param string uri
	 * @return object FrontYAML parsed content instance
	 */
	public function get($uri)
	{
		$content = $this->checkContent($uri);

		$frontYamlParser = new FrontYAML\Parser();

		$content = $frontYamlParser->parse($content);

		return $content;
	}

	/**
	 * Check paths for content
	 *
	 * @param string $uri
	 * @return string Contents of file
	 */
	private function checkContent($uri)
	{
		// Check for private segment
		$uriArray = explode('/', $uri);
		foreach ($uriArray as $segment) {
			if (strpos($segment, '_') === 0) {
				return '';
			}
		}

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

		return $this->checkListingContent($uri);
	}

	/**
	 * Check listing content
	 *
	 * @param string $uri
	 * @return string Contents of file
	 */
	private function checkListingContent($uri)
	{
		// Set the user content path
		$contentPath = USER_PATH . '/content/';

		// Get array of uri
		$uriArray = explode('/', $uri);

		// Get the potential slgu
		$slug = end($uriArray);

		// Unset the slug from the uri array
		unset($uriArray[key($uriArray)]);

		// Get the path
		$path = implode('/', $uriArray);
		$listingParentPath = $contentPath . $path;
		$listingPath = $contentPath . $path . '/_listingContent/';

		// If the listing content dir is not there, return
		if (! is_dir($listingPath)) {
			return '';
		}

		// Get entries
		$entries = scandir($listingPath);
		unset($entries[0]);
		unset($entries[1]);

		// Check for slug match
		foreach ($entries as $entry) {
			$parts = explode('--', $entry);
			$parts = explode('.', end($parts));

			if (count($parts) !== 2) {
				continue;
			}

			if ($parts[0] !== $slug) {
				continue;
			}

			if (is_file($listingPath . $entry)) {
				frame()->set('isListingEntry', true);
				frame()->set('listingPath', $listingParentPath);
				frame()->set('listingParentUri', $path);

				return file_get_contents($listingPath . $entry);
			}
		}

		return '';
	}
}
