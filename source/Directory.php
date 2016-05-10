<?php

namespace Lionar\FileSystem;

use InvalidArgumentException;

class Directory
{
	private $path = '';

	public function __construct ( $path )
	{
		if ( ! is_string ( $path ) or empty ( $path ) or ! is_dir( $path ) )
			throw new InvalidArgumentException ( 'you did not provide a string that can be resolved as a directory' );
		$this->path = $path;
	}

	public function __get ( $property )
	{
		if ( isset ( $this-> { $property } ) )
			return $this-> { $property };
	}
}