<?php

/**
 * Frame
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame;

class Frame
{
	protected $config = array();
	protected $uri = array(
		'rawPath' => false,
		'query' => false,
		'segments' => array(),
		'uriPath' => false
	);

	/**
	 * Set config
	 *
	 * @param string $name
	 * @param mixed $va
	 * @return self
	 */
	public function setConfig($name, $val)
	{
		$this->config[$name] = $val;
		return $this;
	}

	/**
	 * Get config
	 *
	 * @param string $key Optional
	 * @return mixed App config values
	 */
	public function getConfig($key = false)
	{
		if (isset($this->config[$key])) {
			return $this->config[$key];
		}

		if ($key) {
			return null;
		}

		return $this->config;
	}

	/**
	 * Set URI items
	 *
	 * @param string $itemKey
	 * @param mixed $itemVal
	 * @return self
	 */
	public function setUri($itemKey, $itemVal)
	{
		if (! isset($this->uri[$itemKey])) {
			return $this;
		}

		$this->uri[$itemKey] = $itemVal;

		return $this;
	}

	/**
	 * Get uri
	 *
	 * @param string $key Optional
	 * @return mixed URI values
	 */
	public function getUri($key = false)
	{
		if (isset($this->uri[$key])) {
			return $this->uri[$key];
		}

		if ($key) {
			return null;
		}

		return $this->uri;
	}
}
