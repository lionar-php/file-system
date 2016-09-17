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

	public function make ( Directory $directory, Directory $parent = null )
	{
		parent::make ( $directory, $parent );
		if ( file_exists ( $directory->path ) )
			return;
			
		mkdir ( $directory->path );
	}

	public function write ( File $file, Directory $parent = null )
	{
		parent::write ( $file, $parent );
		file_put_contents ( $file->path, $file->content );
	}
}