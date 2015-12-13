<?php

/**
 * Frame app controller
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\Controller;

use Frame\Helper;
use Frame\Model;
use Frame\Service;

class App
{
	/**
	 * Run the app
	 */
	public function run()
	{
		// Get debug settings
		$config = new Model\Config();
		$debug = $config->get('debug');

		// Turn on all error reporting if config calls for it
		if ($debug === true) {
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL);
		}

		// Get all composer autoloads in vendor directory
		Helper\VendorComposer::setup();

		// Get the Uri
		$uri = new Model\Uri();

		// Get content
		$content = new Model\Content($uri->get('path'));

		// Get template path
		$templatePathPriority = new Helper\TemplatePathPriority(
			$content,
			$uri
		);
		$templatePath = $templatePathPriority->get();

		// If template path is null, we need to send an error
		if ($templatePath === null) {
			throw new \Exception('No template was found');
		}

		// Get the Twig environment
		$twigEnv = new Service\TwigEnvironment();

		// Display the template
		$twigEnv->get()->loadTemplate($templatePath)->display([
			'config' => $config->get(),
			'yaml' => $content->get('yaml'),
			'listingParentYaml' => $content->get('listingParentYaml'),
			'body' => $content->get('body'),
			'listingParentBody' => $content->get('listingParentBody'),
			'isListingEntry' => $content->get('isListingEntry'),
			'listingParentUri' => $content->get('listingParentUri'),
			'uri' => $uri->get()
		]);
	}
}
