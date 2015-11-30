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
use Mni\FrontYAML;

class App
{
	public function run()
	{
		// Set config
		$configService = new Service\Config();
		$configService->setFromFiles();

		// Parse URI
		$uriService = new Service\Uri();
		$uriService->set();

		// Get content for current uri
		// place into object
		$contentService = new Service\Content();
		$content = $contentService->get(frame()->getUri('uriPath'));

		// Check for template in front matter, otherwise render default template
		// with object set to twig templating
	}
}
