<?php

namespace FileSystem;

use Accessibility\Readable;
use ArrayAccess;
use InvalidArgumentException;

class FileTree implements ArrayAccess
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

	public function offsetSet ( $NA, $object ) 
	{
		$this->add ( $object );
    }

    public function offsetExists ( $path ) 
    {
    	return isset ( $this->objects [ $path ] );
    }

    public function offsetUnset ( $path ) 
    {
        
    }

    public function offsetGet ( $path ) 
    {
        if ( isset ( $this->objects [ $path ] ) )
        	return $this->objects [ $path ];
    }
}