<?php

/**
 * Frame Listing service
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\Service;

use Frame\Helper;
use Frame\Model;

class Listing
{
	protected $conf = [
		'path' => null,
		'limit' => 10,
		'orderBy' => 'date',
		'sort' => 'desc',
		'offset' => 0
	];

	private $orderBy = [
		'date',
		'slug'
	];

	private $sort = [
		'desc',
		'asc'
	];

	protected $listings = [];

	/**
	 * Listing constructor
	 *
	 * @param array $conf {
	 *     @var string $path
	 *     @var int $limit
	 *     @var string $orderBy
	 *     @var string $sort
	 * }
	 */
	public function __construct($conf)
	{
		// Make sure path is a string
		if (isset($conf['path'])) {
			$this->conf['path'] = (string) $conf['path'];
		}

		// Make sure limit is an integer
		if (isset($conf['limit'])) {
			$this->conf['limit'] = (int) $conf['limit'];
		}

		// Make sure orderBy is an acceptable value
		if (isset($conf['orderBy'])) {
			if (in_array($conf['orderBy'], $this->orderBy)) {
				$this->conf['orderBy'] = $conf['orderBy'];
			}
		}

		// Make sure sort is an acceptable value
		if (isset($conf['sort'])) {
			if (in_array($conf['sort'], $this->sort)) {
				$this->conf['sort'] = $conf['sort'];
			}
		}

		// Make sure offset is an integer
		if (isset($conf['offset'])) {
			$this->conf['offset'] = (int) $conf['offset'];
		}

		$this->setListings();

		if ($this->conf['orderBy'] === 'date') {
			$this->sortListingsByDate($this->conf['sort']);
		}

		if ($this->conf['orderBy'] === 'slug') {
			$this->sortListingsBySlug($this->conf['sort']);
		}

		if ($this->conf['offset']) {
			$this->getOffset($this->conf['offset']);
		}

		if ($this->conf['limit']) {
			$this->getLimit($this->conf['limit']);
		}
	}

	/**
	 * Set listings
	 */
	private function setListings()
	{
		global $userDir;

		if (! $this->conf['path']) {
			$this->listings = null;
		}

		$path = $userDir . '/content/' . $this->conf['path'] . '/_listingContent/';

		if (! is_dir($path)) {
			$this->listings = null;
		}

		$listings = [];

		$listingFiles = Helper\DirArray::files($path);

		foreach (array_values($listingFiles) as $key => $fileName) {
			$meta = new Model\EntryFileName($fileName);

			$rawContent = file_get_contents($path . $fileName);

			$content = new Model\Content(
				$this->conf['path'] . '/' . $meta->get('slug')
			);

			foreach ($meta->asArray() as $metaKey => $metaVal) {
				$listings[$key][$metaKey] = $metaVal;
			}

			$contentArr = $content->asArray();

			if ($contentArr['yaml']) {
				foreach ($contentArr['yaml'] as $yamlKey => $yamlVal) {
					$listings[$key][$yamlKey] = $yamlVal;
				}
			}

			unset($contentArr['yaml']);

			foreach ($contentArr as $contentKey => $contentVal) {
				$listings[$key][$contentKey] = $contentVal;
			}

			$listings[$key]['rawContent'] = $rawContent;
		}

		$this->listings = array_values($listings);
	}

	/**
	 * Sort listings by date
	 *
	 * @param string $dir asc|desc
	 */
	private function sortListingsByDate($dir)
	{
		$listings = [];

		foreach ($this->listings as $listing) {
			$key = (string) $listing['year'];
			$key .= (string) $listing['month'];
			$key .= (string) $listing['day'];
			$key .= (string) $listing['hour'];
			$key .= (string) $listing['minute'];
			$listings[$key] = $listing;
		}

		ksort($listings);

		if ($dir === 'desc') {
			$listings = array_reverse($listings);
		}

		$this->listings = array_values($listings);
	}

	/**
	 * Sort listings by slug
	 *
	 * @param string $dir asc|desc
	 */
	private function sortListingsBySlug($dir)
	{
		$listings = [];

		foreach ($this->listings as $listing) {
			$listings[$listing['slug']] = $listing;
		}

		ksort($listings);

		if ($dir === 'desc') {
			$listings = array_reverse($listings);
		}

		$this->listings = array_values($listings);
	}

	/**
	 * Get offset
	 *
	 * @param int $offset
	 */
	private function getOffset($offset)
	{
		$this->listings = array_splice($this->listings, $offset);
	}

	/**
	 * Get limit
	 *
	 * @param limit
	 */
	private function getLimit($limit)
	{
		$this->listings = array_slice($this->listings, 0, $limit);
	}

	/**
	 * Get listing array
	 *
	 * @return array
	 */
	public function get()
	{
		return $this->listings;
	}
}
