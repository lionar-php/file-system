<?php

namespace Lionar\FileSystem;

use InvalidArgumentException;

class File extends Object
{
	public $content = 'helloo';

	public function write ( $content )
	{
		if ( ! is_string ( $content ) )
			throw new InvalidArgumentException ( '' );
		$this->content = $content;
	}
}