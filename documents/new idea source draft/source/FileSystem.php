<?php

namespace Lionar\FileSystem;

class FileSystem
{
	protected $directories, $files = null;

	public function __construct ( Directory $root, DirectoryCollection $directories, FileCollection $files )
	{
		$this->directories = $directories;
		$this->files = $files;
		$this->directories->add ( $root );
	}

	public function make ( Directory $directory, Directory $parent )
	{
		if ( ! $this->directories->exist ( $parent ) )
			throw new DirectoryNotFoundException ( "Directory $parent has not been found" );
		$directory->moveTo ( $parent );
		$this->directories->add ( $directory );
	}
}