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
		global $sysDir;
		global $userDir;

		$conf = require $sysDir . '/Config/DefaultConfig.php';
		$sysConf = $conf;

		if (is_file($userDir . '/config/config.php')) {
			$userConf = include $userDir . '/config/config.php';

			$conf = array_merge($conf, $userConf);
		}

		return $conf;
	}
}
