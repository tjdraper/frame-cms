<?php

/**
 * Frame IndexedContent service
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\Service;

use Frame\Helper;
use Frame\Model;

class IndexedContent
{
	protected $conf = [
		'path' => null,
		'topLevelDirectories' => false
	];

	protected $content = [];

	/**
	 * Listing constructor
	 *
	 * @param array $conf {
	 *     @var string $path
	 *     @var bool $topLevelDirectories
	 * }
	 */
	public function __construct($conf)
	{
		// Make sure path is a string
		if (isset($conf['path'])) {
			$this->conf['path'] = (string) $conf['path'];
		}

		// Make sure topLevelDirectories is a boolean
		if (isset($conf['topLevelDirectories'])) {
			$this->conf['topLevelDirectories'] = (bool) $conf['topLevelDirectories'];
		}

		if ($this->conf['topLevelDirectories']) {
			$this->setTopLevelDirs();
		} else {
			$this->setContent();
		}
	}

	/**
	 * Set top level directories
	 */
	private function setTopLevelDirs()
	{
		global $userDir;

		if (! $this->conf['path']) {
			$this->content = null;

			return;
		}

		$path = $userDir . '/content/' . $this->conf['path'] . '/';

		if (! is_dir($path)) {
			$this->content = null;

			return;
		}

		$indexedContent = [];

		$dirs = Helper\DirArray::directories($path);

		foreach ($dirs as $dir) {
			$dirFiles = Helper\DirArray::files($path . $dir);

			$split = explode('--', $dir);

			$slug = isset($split[1]) ? $split[1] : $dir;

			$indexedContent[$slug]['slug'] = $slug;

			$index = array_search('index.md', $dirFiles);

			if ($index !== false) {
				unset($dirFiles[$index]);
			}

			$content = new Model\Content($this->conf['path'] . '/' . $dir);

			$contentArr = $content->asArray();

			if ($contentArr['yaml']) {
				foreach ($contentArr['yaml'] as $yamlKey => $yamlVal) {
					$indexedContent[$slug][$yamlKey] = $yamlVal;
				}
			}

			unset($contentArr['yaml']);

			foreach ($contentArr as $contentKey => $contentVal) {
				$indexedContent[$slug][$contentKey] = $contentVal;
			}

			foreach ($dirFiles as $file) {
				$pathInfo = pathinfo($file);
				$fileName = $pathInfo['filename'];

				$split = explode('--', $fileName);

				$fileSlug = isset($split[1]) ? $split[1] : $fileName;

				$indexedContent[$slug]['IndexedContent'][$fileSlug]['slug'] = $fileSlug;

				$content = new Model\Content($this->conf['path'] . '/' . $dir . '/' . $fileName);

				$contentArr = $content->asArray();

				if ($contentArr['yaml']) {
					foreach ($contentArr['yaml'] as $yamlKey => $yamlVal) {
						$indexedContent[$slug]['IndexedContent'][$fileSlug][$yamlKey] = $yamlVal;
					}
				}

				unset($contentArr['yaml']);

				foreach ($contentArr as $contentKey => $contentVal) {
					$indexedContent[$slug]['IndexedContent'][$fileSlug][$contentKey] = $contentVal;
				}
			}
		}

		$this->content = $indexedContent;
	}

	/**
	 * Set listings
	 */
	private function setContent()
	{
		global $userDir;

		if (! $this->conf['path']) {
			$this->content = null;

			return;
		}

		$path = $userDir . '/content/' . $this->conf['path'] . '/';

		if (! is_dir($path)) {
			$this->content = null;

			return;
		}

		$indexedContent = [];

		$files = Helper\DirArray::files($path);

		foreach ($files as $file) {
			$fileName = rtrim($file, '.md');

			$split = explode('--', $fileName);

			$slug = isset($split[1]) ? $split[1] : $fileName;

			$indexedContent[$slug]['slug'] = $slug;

			$content = new Model\Content($this->conf['path'] . '/' . $fileName);

			$contentArr = $content->asArray();

			if ($contentArr['yaml']) {
				foreach ($contentArr['yaml'] as $yamlKey => $yamlVal) {
					$indexedContent[$slug][$yamlKey] = $yamlVal;
				}
			}

			unset($contentArr['yaml']);

			foreach ($contentArr as $contentKey => $contentVal) {
				$indexedContent[$slug][$contentKey] = $contentVal;
			}
		}

		$this->content = $indexedContent;
	}

	/**
	 * Get content array
	 *
	 * @return array
	 */
	public function get()
	{
		return $this->content;
	}
}
