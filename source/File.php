<?php

namespace Lionar\FileSystem;

use InvalidArgumentException;

class File
{
	private $path, $extension = '';
	private $contents = array ( );

	public function __construct ( $path, $contents = array ( ) )
	{
		if ( ! is_string ( $path ) )
			throw new InvalidArgumentException ( 'The file path must be a string' );
		
		$this->path = $path;
		$this->extension =  pathinfo( $path, PATHINFO_EXTENSION );
		$this->contents = $this->adjust( $contents );
	}

	public function append ( $contents = array ( ) )
	{
		$contents = $this->adjust( $contents );
		foreach ( $contents as $content)
			$this->contents [ ] = $content;
	}

	public function __toString (  )
	{
		return $this->path;
	}

	public function __get ( $property )
	{
		return isset ( $this->{ $property } ) ? $this->{ $property } : null;
	}

	private function adjust ( $contents )
	{
		if ( ! is_array ( $contents ) )
			$contents = array ( $contents );
		return $contents;
	}
}