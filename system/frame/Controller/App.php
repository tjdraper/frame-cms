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
		// Set cache to true, will only be disabled for 404
		$cache = true;

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

		// If template path is null we need to send a 404
		if ($templatePath === null) {
			header('HTTP/1.1 404 Not Found');

			$cache = false;

			$templatePath = $config->get('404Template') . '.twig';
		}

		// Get the Twig environment
		$twigEnv = new Service\TwigEnvironment();

		// Set up Twig globals
		Helper\TwigGlobals::add($twigEnv, [
			'config' => $config->get(),
			'uri' => $uri->get()
		]);

		// Display the template
		$renderedTemplate = $twigEnv->get()
			->loadTemplate($templatePath)
			->render([
				'yaml' => $content->get('yaml'),
				'meta' => $content->get('meta'),
				'listingParentYaml' => $content->get('listingParentYaml'),
				'body' => $content->get('body'),
				'listingParentBody' => $content->get('listingParentBody'),
				'isListingEntry' => $content->get('isListingEntry'),
				'listingParentUri' => $content->get('listingParentUri')
			]);

		// Cache rendered template if not disabled in the content YAML
		if (
			$cache and
			! isset($content->get('yaml')['DisableCache']) and
			! isset($content->get('listingParentYaml')['DisableCache'])
		) {
			$cache = new Service\Cache($config, $uri);
			$cache->write($renderedTemplate);
		}

		// Use the output buffer so that calls such as set404 can flush the
		// buffer and output something else entirely
		ob_start();
		echo $renderedTemplate;
		ob_end_flush();
	}
}
