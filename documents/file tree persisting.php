<?php

class FileTree
{
	public function __construct ( Storage $storage )
	{
		$this->storage = $storage;
		$this->objects = $storage->read ( );
	}

	public function add ( Object $object )
	{
		$this->objects [ ] = $object;
	}

	public function __destruct ( )
	{
		$this->storage->save ( $this->objects );
	}
}

/**
 * 1. Pick a root directory
 * 2. Check wether file modification time is same as what we have stored for last modification
 */

$fileTree = new LocalFileTree ( __DIR__ );
$fileTree->blacklist ( 'vendor' );


foreach ( $directories as $directory )
	if ( ! $directory->modificationTime === $storedModificationTime )
		return $this->regenrate ( );
