<?php

namespace FileSystem;

use InvalidArgumentException;

abstract class FileSystem
{
	private $fileTree = null;

	public function __construct ( FileTree $fileTree )
	{
		$this->fileTree = $fileTree;
	}

	public function make ( Directory $directory, Directory $parent = null )
	{					
		if ( ! is_null ( $parent ) )
		{
			$this->checkForParent ( $parent );
			$directory->moveTo ( $parent );
		}

		$this->fileTree->add ( $directory );
	}

	public function write ( File $file, Directory $parent = null )
	{
		if ( ! is_null ( $parent ) )
		{
			$this->checkForParent ( $parent );
			$file->moveTo ( $parent );
		}

		$this->fileTree->add ( $file );
	}

	public function findFilesIn ( Directory $directory )
	{
		$files = array ( );

		foreach ( $directory->objects as $object )
		{
			if ( $object instanceOf File )
				$files [ ] = $object;
			else if ( $object instanceOf Directory )
				$files = array_merge ( $files, $this->findFilesIn ( $object ) );
		}

		return $files;
	}

	private function checkForParent ( Directory $parent )
	{
		if ( ! $this->fileTree->has ( $parent ) )
			throw new InvalidArgumentException ( 
				"The directory at path: $parent->path does not exist." );
	}
}