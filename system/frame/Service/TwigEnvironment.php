<?php

/**
 * Frame TwigEnvironment service
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\Service;

use Frame\Helper;

class TwigEnvironment
{
	protected $twig;

	/**
	 * TwigEnvironment constructor
	 */
	public function __construct()
	{
		global $frameTwigEnv;

		if ($frameTwigEnv) {
			$this->twig = $frameTwigEnv;
		} else {
			$this->twig = $this->setupTwigEnvironment();

			$frameTwigEnv = $this->twig;
		}
	}

	/**
	 * Get twig environment
	 */
	public function get()
	{
		return $this->twig;
	}

	/**
	 * Setup Twig environment
	 */
	private function setupTwigEnvironment()
	{
		global $userDir;

		// Get the Twig loader
		$loader = new \Twig_Loader_Filesystem($userDir . '/templates');

		// Start the Twig environment
		$twig = new \Twig_Environment($loader);

		// Load any filters
		$twig = $this->loadFilters($twig);

		// Load any functions
		$twig = $this->loadFunctions($twig);

		// Load any tags
		$twig = $this->loadTags($twig);

		return $twig;
	}

	/**
	 * Load Twig filters
	 *
	 * @param object $twig Twig instance
	 * @return object $twig Twig instance
	 */
	private function loadFilters($twig)
	{
		global $sysDir;

		$path = $sysDir . '/TwigFilters/';
		$filters = Helper\DirArray::directories($path);

		$namespace = array(
			'\Frame',
			'TwigFilters'
		);

		foreach ($filters as $filterName) {
			if (! is_dir($path . $filterName)) {
				continue;
			}

			$thisNamespace = $namespace;
			$thisNamespace[] = $filterName;
			$thisNamespace[] = $filterName . '_Filter';
			$thisNamespace = implode('\\', $thisNamespace);

			$filter = new \Twig_SimpleFilter(
				lcfirst($filterName),
				array(
					$thisNamespace,
					'index'
				)
			);

			$twig->addFilter($filter);
		}

		return $twig;
	}

	/**
	 * Load twig functions
	 *
	 * @param object $twig Twig instance
	 * @return object Twig instance
	 */
	public function loadFunctions($twig)
	{
		global $sysDir;

		$path = $sysDir . '/TwigFunctions/';
		$functions = Helper\DirArray::directories($path);

		$namespace = array(
			'\Frame',
			'TwigFunctions'
		);

		foreach ($functions as $functionName) {
			if (! is_dir($path . $functionName)) {
				continue;
			}

			$thisNamespace = $namespace;
			$thisNamespace[] = $functionName;
			$thisNamespace[] = $functionName . '_Function';
			$thisNamespace = implode('\\', $thisNamespace);

			$function = new \Twig_SimpleFunction(
				lcfirst($functionName),
				array(
					$thisNamespace,
					'index'
				)
			);

			$twig->addFunction($function);
		}

		return $twig;
	}

	/**
	 * Load twig tags
	 *
	 * @param object $twig Twig instance
	 * @return object Twig instance
	 */
	public function loadTags($twig)
	{
		global $sysDir;

		$path = $sysDir . '/TwigTags/';
		$tags = Helper\DirArray::directories($path);

		$namespace = array(
			'\Frame',
			'TwigTags'
		);

		foreach ($tags as $tagName) {
			if (! is_dir($path . $tagName)) {
				continue;
			}

			$thisNamespace = $namespace;
			$thisNamespace[] = $tagName;
			$thisNamespace[] = $tagName . '_TokenParser';
			$thisNamespace = implode('\\', $thisNamespace);

			$twig->addTokenParser(new $thisNamespace());
		}

		return $twig;
	}
}
