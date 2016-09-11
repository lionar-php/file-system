<?php

namespace Lionar\FileSystem\Collections;

class FilesCollection
{
	private $files = array ( );

	public function __construct ( array $files = array ( ) )
	{
		foreach ( $files as $file )
			$this->add ( $file );
	}

	public function add ( File $file )
	{
		if ( ! $this->files->exist ( $file ) )
			$this->files [ ] = $file;
	}

	public function exist ( File $file )
	{
		foreach ( $this->files as $storedFiles )
			if ( $storedFiles->path === $file->path )
				return true;
		return false;
	}
}