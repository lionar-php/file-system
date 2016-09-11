<?php

namespace Lionar\FileSystem\Collections;

class DirectoryCollection
{
	private $directories = array ( );

	public function __construct ( array $directories = array ( ) )
	{
		foreach ( $directories as $directory )
			$this->add ( $directory );
	}

	public function add ( Directory $directory )
	{
		if ( ! $this->directories->exist ( $directory ) )
			$this->directories [ ] = $directory;
	}

	public function exist ( Directory $directory )
	{
		foreach ( $this->directories as $storedDirectory )
			if ( $storedDirectory->path === $directory->path )
				return true;
		return false;
	}
}