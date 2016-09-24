<?php

namespace FileSystem;

use InvalidArgumentException;
use function Support\is_serialized;

class File extends Object
{
	private $content, $extension = '';

	public function __construct ( $name, Directory $parent = null, $content = '' )
	{
		parent::__construct ( $name, $parent );
		$this->extension = pathinfo ( $name, PATHINFO_EXTENSION );
		$this->write ( $content );
	}

	public function write ( $content )
	{
		if ( ! is_string ( $content ) )
			throw new InvalidArgumentException ( 'The content of a file must be a string' );
		$this->content = $content;
	}

	public function isEmpty ( ) : bool
	{
		if ( is_serialized ( $this->content ) )
			return empty ( unserialize ( $this->content ) );
		return empty ( $this->content );
	}

	public function __get ( $property )
	{
		if ( isset ( $this-> { $property } ) )
			return $this-> { $property };
	}

	public function __toString ( )
	{
		return $this->path;
	}
}