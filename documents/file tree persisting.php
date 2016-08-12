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