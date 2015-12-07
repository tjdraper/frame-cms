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
	protected $isListingEntry;
	protected $listingPath;
	protected $listingParentUri;
	protected $listingParentFrontMatter;
	protected $listingParentContent;
	protected $contentFrontMatter;
	protected $contentBody;
	protected $twig;
	protected $twigTemplate;
	protected $templateVariables = array();

	private $allowedSets = array(
		'isListingEntry',
		'listingPath',
		'listingParentUri',
		'listingParentFrontMatter',
		'listingParentContent',
		'contentFrontMatter',
		'contentBody',
		'twig',
		'twigTemplate'
	);

	private $allowedGets = array(
		'isListingEntry',
		'listingPath',
		'listingParentUri',
		'listingParentFrontMatter',
		'listingParentContent',
		'contentFrontMatter',
		'contentBody',
		'twig',
		'twigTemplate',
		'templateVariables',
		'config',
		'uri',
		'templateVarSets'
	);

	private $templateVarSets = array(
		'config' => 'config',
		'uri' => 'uri',
		'frontMatter' => 'contentFrontMatter',
		'body' => 'contentBody',
		'isListingEntry' => 'isListingEntry',
		'listingPath' => 'listingPath',
		'listingParentUri' => 'listingParentUri',
		'listingParentFrontMatter' => 'listingParentFrontMatter',
		'listingParentContent' => 'listingParentContent',
	);

	/**
	 * Set template variable
	 *
	 * @param string $name
	 * @param mixed $data
	 * @return self
	 */
	public function setTemplateVar($name, $data)
	{
		$this->templateVariables[$name] = $data;

		return $this;
	}

	/**
	 * Set item
	 *
	 * @param string $itemName
	 * @param mixed $itemData
	 * @return self
	 */
	public function set($itemName, $itemData)
	{
		if (in_array($itemName, $this->allowedSets)) {
			$this->{$itemName} = $itemData;
		}

		return $this;
	}

	/**
	 * Get item
	 *
	 * @param string $itemName
	 * @return mixed
	 */
	public function get($itemName)
	{
		if (in_array($itemName, $this->allowedGets)) {
			return $this->{$itemName};
		}

		return null;
	}

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
