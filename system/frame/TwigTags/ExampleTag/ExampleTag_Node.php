<?php

/**
 * Frame ExampleTag node twig tag
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\TwigTags\ExampleTag;

class ExampleTag_Node extends \Twig_Node
{
	public function __construct(
		$name,
		\Twig_Node_Expression $value,
		$line,
		$tag = null
	)
	{
		parent::__construct(
			array('value' => $value),
			array('name' => $name),
			$line,
			$tag
		);
	}

	public function compile(\Twig_Compiler $compiler)
	{
		$compiler
			->addDebugInfo($this)
			->write('$context[\''.$this->getAttribute('name').'\'] = ')
			->subcompile($this->getNode('value'))
			->raw(";\n")
		;
	}
}
