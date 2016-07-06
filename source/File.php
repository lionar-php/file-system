<?php

namespace Lionar\FileSystem;

use InvalidArgumentException;

class File extends Object
{
	private $content = '';

	public function write ( $content )
	{
		if ( ! is_string ( $content ) )
			throw new InvalidArgumentException ( '' );
		$this->content = $content;
	}

	public function __get ( $property )
	{
		if ( isset ( $this-> { $property } ) )
			return $this-> { $property };
	}
}