<?php

namespace FileSystem;

use Accessibility\Readable;
use FileSystem\Exceptions\ObjectNotFoundException;

class Directory extends Object
{
	use Readable;

	private $objects = array ( );

	public function add ( Object $object )
	{
		$this->objects [ $object->name ] = $object;
		if ( ! $object->isDirectlyIn ( $this ) )
			$object->moveTo ( $this );
	}

	public function remove ( Object $object )
	{
		if (  ! $this->has ( $object ) )
			throw new ObjectNotFoundException ( $object );
		
		unset ( $this->objects [ $object->name ] );
	}

	public function has ( Object $object )
	{
		return ( bool ) ( isset ( $this->objects [ $object->name ] ) );
	}

	public function moveTo ( Directory $directory )
	{
		parent::moveTo ( $directory );
		foreach ( $this->objects as $object )
			$object->moveTo ( $this );
	}
}