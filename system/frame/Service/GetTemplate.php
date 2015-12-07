<?php

/**
 * Frame
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\Service;

class GetTemplate
{
	private $fileExtensions = array(
		'twig',
		'html',
		'htm',
		'tmpl'
	);

	/**
	 * Get template
	 *
	 * @return string
	 */
	public function get()
	{
		$frontMatter = frame()->get('frontMatter');
		$template = null;

		if (isset($frontMatter['Template'])) {
			$template = $this->getTemplateContents($frontMatter['Template']);
		} else {
			$uri = frame()->getUri();

			$template = $this->getTemplateContents($uri['uriPath']);

			if (! $template) {
				$template = $this->getTemplateContents($uri['uriPath'] . '/index');
			}
		}

		if ($template === null) {
			exit('No template was found');
		}

		return $template;
	}

	/**
	 * Get template contents
	 *
	 * @param string $templatePath
	 * @return null|string Template contents or null if no template
	 */
	private function getTemplateContents($templatePath)
	{
		$templatePath = USER_PATH . '/templates/' . $templatePath;

		foreach ($this->fileExtensions as $ext) {
			if (is_file($templatePath . '.' . $ext)) {
				return trim(file_get_contents($templatePath . '.' . $ext));
			}
		}

		return null;
	}
}
