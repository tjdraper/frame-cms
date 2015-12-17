<?php

/**
 * Frame Set404 twig function
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\TwigFunctions\Set404;

use Frame\Model;
use Frame\Service;

class Set404_Function
{
	/**
	 * Set 404
	 */
	public static function index()
	{
		// Set 404 header
		header('HTTP/1.1 404 Not Found');

		// Get config
		$config = new Model\Config();

		// Get 404 template
		$template = $config->get('404Template') . '.twig';

		// Get the Twig environment
		$twigEnv = new Service\TwigEnvironment();

		// Get the Uri
		$uri = new Model\Uri();

		// Display the template
		$twigEnv->get()
			->loadTemplate($template)
			->display([
				'config' => $config->get(),
				'yaml' => [],
				'meta' => [],
				'listingParentYaml' => [],
				'body' => '',
				'listingParentBody' => '',
				'isListingEntry' => false,
				'listingParentUri' => null,
				'uri' => $uri->get()
			]);

		exit();
	}
}
