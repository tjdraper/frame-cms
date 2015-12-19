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
		// Clear the output buffer of any previous content
		ob_clean();

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
		$renderedTemplate = $twigEnv->get()
			->loadTemplate($template)
			->render([]);

		// Put the content in the output buffer
		ob_start();
		echo $renderedTemplate;
		ob_end_flush();

		// End the script
		exit();
	}
}
