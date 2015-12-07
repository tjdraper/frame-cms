<?php

/**
 * Frame SetupTwigEnvironment service
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\Service;

class SetupTwigEnvironment
{
	/**
	 * Setup twig template environment
	 */
	public function set()
	{
		// Get the Twig loader
		$loader = new \Twig_Loader_Filesystem(USER_PATH . '/templates');

		// Setup the Twig environment
		$twig = new \Twig_Environment($loader);

		// Load any filters
		$twig = $this->loadFilters($twig);

		// Load any functions
		$twig = $this->loadFunctions($twig);

		// Load any tags
		$twig = $this->loadTags($twig);

		// Set twig to the frame object
		frame()->set('twig', $twig);
	}

	/**
	 * Load filters
	 *
	 * @param object $twig Twig instance
	 * @return object Twig instance
	 */
	private function loadFilters($twig)
	{
		$filters = scandir(FRAME_PATH . '/TwigFilters/');
		unset($filters[0]);
		unset($filters[1]);

		foreach ($filters as $filterName) {
			$filterName = str_replace('.php', '', $filterName);

			$namespace = array(
				'Frame',
				'TwigFilters',
				$filterName
			);

			$namespace = implode('\\', $namespace);

			$filter = new \Twig_SimpleFilter(
				$filterName,
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
		$functions = scandir(FRAME_PATH . '/TwigFunctions/');
		unset($functions[0]);
		unset($functions[1]);

		foreach ($functions as $functionName) {
			$functionName = str_replace('.php', '', $functionName);

			$namespace = array(
				'Frame',
				'TwigFunctions',
				$functionName
			);

			$namespace = implode('\\', $namespace);

			$function = new \Twig_SimpleFunction(
				$functionName,
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
		$tags = scandir(FRAME_PATH . '/TwigTags/');
		unset($tags[0]);
		unset($tags[1]);

		foreach ($tags as $tagName) {
			$namespace = array(
				'\Frame',
				'TwigTags',
				$tagName,
				$tagName . '_TokenParser'
			);

			$namespace = implode('\\', $namespace);

			$twig->addTokenParser(new $namespace());
		}

		return $twig;
	}
}
