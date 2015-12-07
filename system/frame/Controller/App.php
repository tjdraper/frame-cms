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

		// Get content for current uri, place into object
		$contentService = new Service\Content();
		$parsedContent = $contentService->get(frame()->getUri('uriPath'));

		// Set the content to the frame global
		frame()->set('contentFrontMatter', $parsedContent->getYAML());
		frame()->set('contentBody', $parsedContent->getContent());

		// Get listing parent information if applicable
		if (frame()->get('isListingEntry')) {
			$parsedListingIndex = $contentService->get(
				frame()->get('listingParentUri')
			);

			frame()->set(
				'listingParentFrontMatter',
				$parsedListingIndex->getYAML()
			);

			frame()->set(
				'listingParentContent',
				$parsedListingIndex->getContent()
			);
		}

		// Setup the Twig template environment
		$setTwigEnvironment = new Service\SetupTwigEnvironment();
		$setTwigEnvironment->set();

		// Set template variables
		$setTemplateVariables = new Service\SetTemplateVariables();
		$setTemplateVariables->set();

		// Get template
		$getTemplate = new Service\GetTemplate();
		$getTemplate->get();

		frame()->get('twigTemplate')->display(
			frame()->get('templateVariables')
		);
	}
}
