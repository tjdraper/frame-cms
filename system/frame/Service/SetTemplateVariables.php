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
		$varSets = frame()->get('templateVarSets');

		foreach ($varSets as $key => $var) {
			frame()->setTemplateVar($key, frame()->get($var));
		}
	}
}
