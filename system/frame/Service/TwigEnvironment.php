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
		$filters = scandir($path);
		unset($filters[0]);
		unset($filters[1]);

		$namespace = array(
			'\Frame',
			'TwigFilters'
		);

		foreach ($filters as $filterName) {
			if (! is_dir($path . $filterName)) {
				continue;
			}

			$namespace[] = $filterName;
			$namespace[] = $filterName . '_Filter';
			$namespace = implode('\\', $namespace);

			$filter = new \Twig_SimpleFilter(
				lcfirst($filterName),
				array(
					$namespace,
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
		$functions = scandir($path);
		unset($functions[0]);
		unset($functions[1]);

		$namespace = array(
			'\Frame',
			'TwigFunctions'
		);

		foreach ($functions as $functionName) {
			if (! is_dir($path . $functionName)) {
				continue;
			}

			$namespace[] = $functionName;
			$namespace[] = $functionName . '_Function';
			$namespace = implode('\\', $namespace);

			$function = new \Twig_SimpleFunction(
				lcfirst($functionName),
				array(
					$namespace,
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
		$tags = scandir($path);
		unset($tags[0]);
		unset($tags[1]);

		$namespace = array(
			'\Frame',
			'TwigTags'
		);

		foreach ($tags as $tagName) {
			if (! is_dir($path . $tagName)) {
				continue;
			}

			$namespace[] = $tagName;
			$namespace[] = $tagName . '_TokenParser';
			$namespace = implode('\\', $namespace);

			$twig->addTokenParser(new $namespace());
		}

		return $twig;
	}
}
