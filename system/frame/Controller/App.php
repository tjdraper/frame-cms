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

use Frame\Service;
use Frame\Helper;

class App
{
	public function run()
	{
		// Set config
		$configService = new Service\Config();
		$configService->setFromFiles();

		// Get all Vendor directory composer autoloads
		$vendorComposerHelper = new Helper\VendorComposer();
		$vendorComposerHelper->setup();

		// Parse URI
		$uriService = new Service\Uri();
		$uriService->set();

		// Get content for current uri
		// place into object
		$contentService = new Service\Content();
		$parsedContent = $contentService->get(frame()->getUri('uriPath'));

		// Set the content to the frame global
		frame()->set('frontMatter', $parsedContent->getYAML());
		frame()->set('content', $parsedContent->getContent());

		// Get template
		$getTemplate = new Service\GetTemplate();
		$template = $getTemplate->get();

		// Set twig variables including globals (should there be a YAML file
		// somewhere?) and parse the template through twig, then output

		var_dump($template);
		die;
	}
}
