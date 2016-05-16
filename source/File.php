<?php

namespace Lionar\FileSystem;

use InvalidArgumentException;

class File
{
	private $path, $extension = '';

	public function __construct ( $path )
	{
		if ( ! is_string ( $path ) )
			throw new InvalidArgumentException ( 'The file path must be a string' );
		
		$this->path = $path;
		$this->extension =  pathinfo( $path, PATHINFO_EXTENSION );
	}

	public function __toString (  )
	{
		return $this->path;
	}

	public function __get ( $property )
	{
		return isset ( $this->{ $property } ) ? $this->{ $property } : null;
	}
}