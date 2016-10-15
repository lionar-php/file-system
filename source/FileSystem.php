<?php

namespace FileSystem;

use FileSystem\Exceptions\ObjectNotFoundException;

class FileSystem
{
	private $fileTree, $manager = null;

	public function __construct ( FileTree $fileTree, Manager $manager )
	{
		$this->fileTree = $fileTree;
		$this->manager = $manager;
	}

	public function make ( Directory $directory, Directory $parent = null )
	{					
		if ( ! is_null ( $parent ) )
			$parent->add ( $directory );

		$this->fileTree->add ( $directory );
		$this->manager->make ( $directory );
	}

	public function write ( File $file, Directory $parent = null )
	{
		if ( ! is_null ( $parent ) )
			$parent->add ( $file );
		
		$this->fileTree->add ( $file );
		$this->manager->write ( $file );
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
}