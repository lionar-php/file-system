<?php

namespace Lionar\FileSystem;

use InvalidArgumentException;

class File
{
	private $path, $extension = '';

	public function __construct ( $path )
	{
		if ( ! is_string ( $path ) or empty ( $extension = pathinfo( $path, PATHINFO_EXTENSION ) ) )
			throw new InvalidArgumentException ( );
		
		$this->path = $path;
		$this->extension = $extension;
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