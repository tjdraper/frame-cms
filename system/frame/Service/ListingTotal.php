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

class ListingTotal
{
	protected $conf = [
		'path' => null,
		'offset' => 0
	];

	protected $total = null;

	/**
	 * ListingTotal constructor
	 *
	 * @param array $conf {
	 *     @var string $path
	 *     @var int $offset
	 * }
	 */
	public function __construct($conf)
	{
		// Make sure path is a string
		if (isset($conf['path'])) {
			$this->conf['path'] = (string) $conf['path'];
		}

		// Make sure offset is an integer
		if (isset($conf['offset'])) {
			$this->conf['offset'] = (int) $conf['offset'];
		}

		$this->setTotal();

		if ($this->conf['offset']) {
			$this->getOffset($this->conf['offset']);
		}
	}

	/**
	 * Set total listings
	 */
	private function setTotal()
	{
		global $userDir;

		if (! $this->conf['path']) {
			$this->total = null;
		}

		$path = $userDir . '/content/' . $this->conf['path'] . '/_listingContent/';

		if (! is_dir($path)) {
			$this->total = null;
		}

		$listingFiles = Helper\DirArray::files($path);

		$this->total = count($listingFiles);
	}

	/**
	 * Get offset
	 *
	 * @param int $offset
	 */
	private function getOffset($offset)
	{
		$total = ($this->total - $offset) ?: 0;
		$total = $total < 0 ? 0 : $total;
		$this->total = $total;
	}

	/**
	 * Get listing total
	 *
	 * @return int
	 */
	public function get()
	{
		return $this->total;
	}
}
