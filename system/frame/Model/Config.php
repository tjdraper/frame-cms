<?php

/**
 * Frame Config Model
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\Model;

use Frame\Helper;

class Config
{
	protected $config = [];

	/**
	 * Config constructor
	 */
	public function __construct()
	{
		global $frameConfig;

		if ($frameConfig) {
			$this->config = $frameConfig;
		} else {
			$this->config = $this->getFileConfig();

			$frameConfig = $this->config;
		}
	}

	/**
	 * Get config
	 *
	 * @param string $key Optional
	 * @return mixed Config values
	 */
	public function get($key = false)
	{
		if (isset($this->config[$key])) {
			return $this->config[$key];
		}

		if ($key) {
			return null;
		}

		return $this->config;
	}

	/**
	 * Set config
	 *
	 * @param string $name
	 * @param mixed $val
	 * @return self
	 */
	public function set($name, $val)
	{
		$this->config[$name] = $val;
		return $this;
	}

	/**
	 * Save current config state to memory
	 */
	public function save()
	{
		global $frameConfig;

		$frameConfig = $this->config;
	}

	/**
	 * Get config from files
	 *
	 * @return array
	 */
	private function getFileConfig()
	{
		// Get globals
		global $sysDir;
		global $userDir;

		// Set paths
		$userConfigDir = $userDir . '/config/';
		$conf = require $sysDir . '/Config/DefaultConfig.php';

		// Make sure the user config directory exists
		if (! is_dir($userConfigDir)) {
			return $conf;
		}

		// Get the user config files
		$configFiles = Helper\DirArray::files($userConfigDir);

		// Loop through each file and merge in its contents
		foreach ($configFiles as $file) {
			$fileConf = include $userConfigDir . $file;

			if (gettype($fileConf) === 'array') {
				$conf = array_merge($conf, $fileConf);
			}
		}

		return $conf;
	}
}
