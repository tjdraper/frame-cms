<?php

/**
 * Frame ExampleTag Token parser twig tag
 *
 * @package frame
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/frame-cms
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

namespace Frame\TwigTags\ExampleTag;

class ExampleTag_TokenParser extends \Twig_TokenParser
{
	/**
	 * Get tag
	 *
	 * @return string Tag name
	 */
	public function getTag()
	{
		return 'ExampleTag';
	}

	public function parse(\Twig_Token $token)
	{
		$parser = $this->parser;
		$stream = $parser->getStream();

		$name = $stream->expect(\Twig_Token::NAME_TYPE)->getValue();
		$stream->expect(\Twig_Token::OPERATOR_TYPE, '=');
		$value = $parser->getExpressionParser()->parseExpression();
		$stream->expect(\Twig_Token::BLOCK_END_TYPE);

		return new ExampleTag_Node(
			$name,
			$value,
			$token->getLine(),
			$this->getTag()
		);
	}
}
