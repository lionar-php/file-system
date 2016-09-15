<?php

namespace FileSystem;

use InvalidArgumentException;

class FileTree
{
	private $objects = array ( );

	public function __construct ( array $objects = array ( ) )
	{
		foreach ( $objects as $object )
			$this->add ( $object );
	}

	public function add ( Object $object )
	{
		$this->objects [ $object->key ] = clone $object;
	}

	public function has ( Object $object )
	{
		return isset ( $this->objects [ $object->key ] );
	}

	public function __get ( $property )
	{
		if ( isset ( $this-> { $property } ) )
			return $this-> { $property };
	}
}