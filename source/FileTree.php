<?php

namespace FileSystem;

use Accessibility\Readable;
use InvalidArgumentException;

class FileTree
{
	use Readable;

	private $objects = array ( );

	public function __construct ( array $objects = array ( ) )
	{
		foreach ( $objects as $object )
			$this->add ( $object );
	}

	public function add ( Object $object )
	{
		if ( $this->has ( $object ) )
			return;
			
		$this->objects [ $object->path ] = $object;
	}

	public function has ( Object $object )
	{
		return isset ( $this->objects [ $object->path ] );
	}
}