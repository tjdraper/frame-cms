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
		global $userDir;

		$path = $sysDir . '/TwigFilters/';
		$filters = Helper\DirArray::directories($path);

		$userPath = $userDir . '/TwigFilters/';
		$userFilters = Helper\DirArray::directories($userPath);

		$filters = array_merge($filters, $userFilters);

		$namespace = array(
			'\Frame',
			'TwigFilters'
		);

		foreach ($filters as $filterName) {
			if (
				! is_dir($path . $filterName) AND
				! is_dir($userPath . $filterName)
			) {
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
		global $userDir;

		$path = $sysDir . '/TwigFunctions/';
		$functions = Helper\DirArray::directories($path);

		$userPath = $userDir . '/TwigFunctions/';
		$userFunctions = Helper\DirArray::directories($userPath);

		$functions = array_merge($functions, $userFunctions);

		$namespace = array(
			'\Frame',
			'TwigFunctions'
		);

		foreach ($functions as $functionName) {
			if (
				! is_dir($path . $functionName) AND
				! is_dir($userPath . $functionName)
			) {
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
		global $userDir;

		$path = $sysDir . '/TwigTags/';
		$tags = Helper\DirArray::directories($path);

		$userPath = $userDir . '/TwigTagsTwigTags/';
		$userTags = Helper\DirArray::directories($userPath);

		$tags = array_merge($tags, $userTags);

		$namespace = array(
			'\Frame',
			'TwigTags'
		);

		foreach ($tags as $tagName) {
			if (
				! is_dir($path . $tagName) AND
				! is_dir($userPath . $tagName)
			) {
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
