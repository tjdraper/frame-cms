<?php

/**
 * Frame Content Model
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\Model;

use Mni\FrontYAML;
use Frame\Helper;

class Content
{
	private $content = [];

	/**
	 * Content constructor
	 *
	 * @param string $uri
	 */
	public function __construct($uri)
	{
		global $frameContent;

		if (! $frameContent) {
			$frameContent = [];
		}

		// If this content has already been retrived, set it
		if (isset($frameContent[$uri])) {
			$this->content = $frameContent[$uri];
		} else {
			// Get the YAML/Markdown parser
			$frontYamlParser = new FrontYAML\Parser();

			// Get content for this uri
			$content = $this->getContent($uri);

			// Check if we can parse content
			if ($content !== null) {
				// Parse the content
				$parsed = $frontYamlParser->parse($content);

				// Set content items
				$content = [
					'yaml' => $parsed->getYAML(),
					'body' => $parsed->getContent(),
					'hasListings' => $this->checkForListings($uri)
				];

			// Check if this is a listing entry
			} else {
				$listing = $this->getListing($uri);

				if ($listing) {
					// Get parent content
					$parentContent = $this->getContent($listing['listingParentUri']);

					// Parse the content
					$parsed = $frontYamlParser->parse($listing['content']);

					// Parse Parent Content
					$parsedParent = $frontYamlParser->parse($parentContent);

					// Set content items
					$content = [
						'meta' => $listing['meta'],
						'yaml' => $parsed->getYAML(),
						'listingParentYaml' => $parsedParent->getYAML(),
						'body' => $parsed->getContent(),
						'listingParentBody' => $parsedParent->getContent(),
						'isListingEntry' => true,
						'listingPath' => $listing['listingPath'],
						'listingParentUri' => $listing['listingParentUri'],
						'hasListings' => false
					];
				}
			}

			$this->content = $content;

			$frameContent[$uri] = $this->content;
		}
	}

	/**
	 * Get content item
	 *
	 * @param string $item
	 * @return mixed
	 */
	public function get($item = false)
	{
		if ($item) {
			if (isset($this->content[$item])) {
				return $this->content[$item];
			}

			return null;
		}

		return $this->content;
	}

	/**
	 * Get content array
	 *
	 * @return array
	 */
	public function asArray()
	{
		return $this->content;
	}

	/**
	 * Get content for specified uri
	 *
	 * @param string $uri
	 */
	private function getContent($uri)
	{
		// Check for private segment
		$uriArray = explode('/', $uri);
		foreach ($uriArray as $segment) {
			if (strpos($segment, '_') === 0) {
				return null;
			}
		}

		global $userDir;

		// Set index if uri is empty
		$uri = $uri ?: 'index';

		// Set the user content path
		$contentPath = $userDir . '/content/';

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

		return null;
	}

	/**
	 * Get listing content
	 *
	 * @param string $uri
	 */
	private function getListing($uri)
	{
		global $userDir;

		// Set the user content path
		$contentPath = $userDir . '/content/';

		// Get array of uri
		$uriArray = explode('/', $uri);

		// Get the potential slug
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
		$entries = Helper\DirArray::files($listingPath);

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

			$meta = new EntryFileName($entry);

			if (is_file($listingPath . $entry)) {
				return [
					'listingPath' => $listingParentPath,
					'listingParentUri' => $path,
					'content' => file_get_contents($listingPath . $entry),
					'meta' => $meta->asArray()
				];
			}
		}

		return null;
	}

	/**
	 * Check for listings
	 *
	 * @param string $uri
	 * @return bool
	 */
	private function checkForListings($uri)
	{
		global $userDir;

		// Set the user content path
		$contentPath = $userDir . '/content/';

		return is_dir($contentPath . $uri . '/_listingContent');
	}
}
