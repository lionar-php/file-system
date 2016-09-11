<?php

class SingleDirectoryFinder
{
	private $directories = null;

	public function __construct ( DirectoryCollection $directories )
	{
		$this->directories = $directories;
	}

	public function identifiedBy ( $path )
	{
		$this->inspect ( $path );
			
		foreach ( $this->directories as $directory )
			if ( $directory->path === $path )
				return $directory;
	}

	private function inspect ( $path )
	{
		if ( ! is_string ( $path ) )
			throw new InvalidArgumentException ( "$path is not a valid path" );
	}
}