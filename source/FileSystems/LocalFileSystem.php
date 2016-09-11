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

	public function make ( Directory $newDirectory, Directory $parent = null )
	{
		parent::make ( $newDirectory, $parent );
		if ( file_exists ( $newDirectory->path ) )
			throw new InvalidArgumentException ( 'That directory already exists' );
			
		mkdir ( $newDirectory->path );
	}

	public function write ( $content, File $file, Directory $parent = null )
	{
		parent::write ( $content, $file, $parent );
		file_put_contents ( $file->path, $content );
		$file->write ( $content );
	}
}