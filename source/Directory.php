<?php

namespace Lionar\FileSystem;

class Directory extends Object
{
	public $objects = array ( );

	public function add ( Object $object )
	{
		$this->objects [ ] = $object;
		if ( ! $object->parent == $this )
			$object->moveTo ( $this );
	}

	public function moveTo ( Directory $directory )
	{
		parent::moveTo ( $directory );
		foreach ( $this->objects as $object )
			$object->moveTo ( $this );
	}

	public function has ( Object $object )
	{
		return in_array ( $object, $this->objects );
	}

	public function remove ( Object $object )
	{
		if ( ! $this->has ( $object ) )
			return;

		$key = array_search ( $object, $this->objects );
		$object = $this->objects [ $key ];
		unset ( $this->objects [ $key ] );
		$object->removeFromParent ( );
	}
}