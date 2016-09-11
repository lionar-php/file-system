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
		$this->checkForAlreadyExistentObject ( $directory );
					
		if ( ! is_null ( $parent ) )
		{
			$this->checkForParent ( $parent );
			$directory->moveTo ( $parent );
		}

		$this->fileTree->add ( $directory );
	}

	public function write ( $content, File $file, Directory $parent = null )
	{
		$this->checkForAlreadyExistentObject ( $file );

		if ( ! is_null ( $parent ) )
		{
			$this->checkForParent ( $parent );
			$file->moveTo ( $parent );
		}

		$file->write ( $content );
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
			throw new InvalidArgumentException ( 'That parent directory does not exist' );
	}

	private function checkForAlreadyExistentObject ( Object $object )
	{
		if ( $this->fileTree->has ( $object ) )
			throw new InvalidArgumentException ( 'That object already exists' );
	}
}