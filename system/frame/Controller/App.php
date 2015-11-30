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

		// exit($parsedContent->getContent());
		var_dump(get_class_methods($parsedContent));
		die;

		// Check for template in front matter, otherwise render default template
		// with object set to twig templating
	}
}
