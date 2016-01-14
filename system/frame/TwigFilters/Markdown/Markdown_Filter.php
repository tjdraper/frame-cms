<?php

/**
 * Markdown twig filter
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\TwigFilters\Markdown;

use Mni\FrontYAML;

class Markdown_Filter
{
	/**
	 * Markdown filter
	 *
	 * @param string $string
	 * @return string
	 */
	public static function index($string)
	{
		$frontYamlParser = new FrontYAML\Parser();

		$parsed = $frontYamlParser->parse($string);

		return $parsed->getContent();
	}
}
