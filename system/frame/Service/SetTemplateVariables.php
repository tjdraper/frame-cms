<?php

/**
 * Frame SetTemplateVariables service
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\Service;

class SetTemplateVariables
{
	/**
	 * Set template variables
	 */
	public function set()
	{
		frame()->setTemplateVar('config', frame()->get('config'));

		frame()->setTemplateVar('uri', frame()->get('uri'));

		frame()->setTemplateVar(
			'frontMatter',
			frame()->get('contentFrontMatter')
		);

		frame()->setTemplateVar(
			'body',
			frame()->get('contentBody')
		);
	}
}
