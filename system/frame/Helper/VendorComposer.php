<?php

/**
 * Frame VendorComposer helper
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\Helper;

class VendorComposer
{
	/**
	 * Set up Vendor dir composer autoloads
	 */
	public static function setup()
	{
		global $sysDir;

		// Set the vendor path
		$vendorPath = $sysDir . '/Vendor/';
		$composerAutoPath = '/vendor/autoload.php';

		// Get array of directories
		$vendorDirectories = DirArray::directories($vendorPath);

		// Check for composer autoload file
		foreach ($vendorDirectories as $directory) {
			$autoFile = $vendorPath . $directory . $composerAutoPath;

			if (is_file($autoFile)) {
				require_once $autoFile;
			}
		}
	}
}
