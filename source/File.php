<?php

namespace FileSystem;

use InvalidArgumentException;

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
			throw new InvalidArgumentException ( '' );
		$this->content = $content;
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