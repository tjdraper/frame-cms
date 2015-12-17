<?php

/**
 * Frame EntryFileName
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\Model;

class EntryFileName
{
	protected $filename;
	protected $year;
	protected $month;
	protected $monthShort;
	protected $day;
	protected $dayShort;
	protected $hour;
	protected $hourShort;
	protected $minute;
	protected $amPm;
	protected $slug;
	protected $dateTime;

	/**
	 * EntryFileName constructor
	 *
	 * @param string filename
	 */
	public function __construct($filename)
	{
		$this->filename = $filename;

		$parts = explode('--', $filename);

		$ymd = explode('-', $parts[0]);
		$this->year = $y = $ymd[0];
		$this->month = $m = strlen($ymd[1]) === 1 ? 0 . $ymd[1] : $ymd[1];
		$this->monthShort = ltrim($ymd[1], 0);
		$this->day = $d = strlen($ymd[2]) === 1 ? 0 . $ymd[2] : $ymd[2];
		$this->dayShort = ltrim($ymd[2], 0);

		$time = explode('-', $parts[1]);
		$this->hour = $h = strlen($time[0]) === 1 ? 0 . $time[0] : $time[0];
		$this->hourShort = ltrim($time[0], 0);
		$this->minute = $min = strlen($time[1]) === 1 ? 0 . $time[1] : $time[1];
		$this->amPm = $amPm = ltrim($time[2], 0);

		$slug = explode('.', $parts[2]);
		$this->slug = $slug[0];

		$this->dateTime = date_create("{$y}-{$m}-{$d} {$h}:{$min} {$amPm}");
	}

	/**
	 * Get param
	 *
	 * @param string $item
	 * @return mixed
	 */
	public function get($item)
	{
		if (isset($this->{$item})) {
			return $this->{$item};
		}

		return null;
	}

	/**
	 * Return an array
	 *
	 * @return array
	 */
	public function asArray()
	{
		return get_object_vars($this);
	}
}
