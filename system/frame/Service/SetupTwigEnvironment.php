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
		$cacheDir = USER_PATH . '/cache/twig_compilation_cache';

		if (! is_dir($cacheDir)) {
			mkdir($cacheDir, 0777, true);
		}

		$loader = new \Twig_Loader_Filesystem(USER_PATH . '/templates');

		$twig = new \Twig_Environment($loader, array(
			'cache' => $cacheDir
		));

		frame()->set('twig', $twig);
	}
}
