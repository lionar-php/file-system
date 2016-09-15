<?php

namespace FileSystem\FileSystems;

use InvalidArgumentException;
use FileSystem\Directory;
use FileSystem\File;
use FileSystem\FileSystem;
use FileSystem\FileTree;
use FileSystem\Object;

class LocalFileSystem extends FileSystem
{
	public function __construct ( FileTree $fileTree )
	{
		parent::__construct ( $fileTree );
	}

	public function make ( Directory $directory )
	{
		parent::make ( $directory );
		if ( file_exists ( $directory->path ) )
			throw new InvalidArgumentException ( 'That directory already exists' );
			
		mkdir ( $directory->path );
	}

	public function write ( File $file )
	{
		parent::write ( $file );
		file_put_contents ( $file->path, $file->content );
	}
}