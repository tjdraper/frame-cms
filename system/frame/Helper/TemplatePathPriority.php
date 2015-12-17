<?php

/**
 * Frame TemplatePathPriority
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\Helper;

use Frame\Model\Content;
use Frame\Model\Uri;

class TemplatePathPriority
{
	protected $content;
	protected $uri;

	/**
	 * TemplatePathPriority constructor
	 *
	 * @param object $content Instance of Frame\Model\Content
	 * @param object $uri Instance of Frame\Model\Uri
	 * @return string
	 */
	public function __construct(Content $content = null, Uri $uri = null)
	{
		$this->content = $content;
		$this->uri = $uri;
	}

	/**
	 * Get the path by priority
	 *
	 * @return null|string Template path
	 */
	public function get()
	{
		// Make sure one of the items we need is present
		if (! $this->content and ! $this->uri) {
			return '';
		}

		$yaml = false;
		$listingParentYaml = false;

		// If there is content, set the yaml
		if ($this->content) {
			$yaml = $this->content->get('yaml');
			$listingParentYaml = $this->content->get('listingParentYaml');
		}

		// If there is yaml, check for a template
		if ($yaml) {
			if (isset($yaml['Template'])) {
				$path = $this->checkPath($yaml['Template']);

				if ($path) {
					return $path;
				}
			}
		}

		// If there is parent yaml, check for listing template or template
		if ($listingParentYaml) {
			if (isset($listingParentYaml['ListingTemplate'])) {
				$path = $this->checkPath($listingParentYaml['ListingTemplate']);

				if ($path) {
					return $path;
				}
			}

			if (isset($listingParentYaml['Template'])) {
				$path = $this->checkPath($listingParentYaml['Template']);

				if ($path) {
					return $path;
				}
			}
		}

		// If we've made it this far, we need to check for private segment
		if (! $this->hasPrivateSegment()) {
			// If there is a template at the URI location, return that
			$path = $this->checkPath($this->uri->get('path'));

			if ($path) {
				return $path;
			}
		}

		return null;
	}

	/**
	 * Check a path for a template
	 *
	 * @param string $template
	 * @param null|string The path with extension of the template
	 */
	public function checkPath($template)
	{
		global $userDir;

		$path = $userDir . '/templates/';

		if (file_exists($path . $template . '.twig')) {
			return $template . '.twig';
		}

		return null;
	}

	/**
	 * Check if uri has private segment
	 *
	 * @return bool
	 */
	private function hasPrivateSegment()
	{
		foreach ($this->uri->get('segments') as $segment) {
			if (strpos($segment, '_') === 0) {
				return true;
			}
		}

		return false;
	}
}
