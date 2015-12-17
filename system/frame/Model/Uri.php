<?php

/**
 * Frame
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\Model;

class Uri
{
	protected $uri;

	/**
	 * Uri constructor
	 */
	public function __construct()
	{
		global $frameUri;

		if ($frameUri) {
			$this->uri = $frameUri;
		} else {
			$this->uri = $this->parseUri();

			$frameUri = $this->uri;
		}
	}

	/**
	 * Get Uri
	 *
	 * @param string $item Optional - Specific uri item to get
	 * @return mixed
	 */
	public function get($item = '')
	{
		if ($item) {
			if (isset($this->uri[$item])) {
				return $this->uri[$item];
			}

			return null;
		}

		return $this->uri;
	}

	/**
	 * Set Uri item
	 *
	 * @param string $name
	 * @param mixed $val
	 * @return self
	 */
	public function set($name, $val)
	{
		if (isset($this->uri[$name])) {
			$this->uri[$name] = $val;
		}

		return $this;
	}

	/**
	 * Save current URI state to memory
	 */
	public function save()
	{
		global $frameUri;

		$frameUri = $this->uri;
	}

	/**
	 * Get the current Uri
	 */
	private function parseUri()
	{
		// Set page to 1 initially
		$page = 1;

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

		$segCount = count($uriSegments);

		// Check for pagination
		if (
			count($uriSegments) > 1 and
			ctype_digit($uriSegments[$segCount - 1]) and
			(int) $uriSegments[$segCount - 1] > 1 and
			$uriSegments[$segCount - 2] === 'page'
		) {
			$page = (int) $uriSegments[$segCount - 1];
			unset($uriSegments[$segCount - 1]);
			unset($uriSegments[$segCount - 2]);
		}

		return [
			'raw' => $uriParts['path'],
			'segments' => array_values($uriSegments),
			'path' => implode('/', $uriSegments),
			'query' => isset($uriParts['query']) ? $uriParts['query'] : false,
			'page' => $page
		];
	}
}
