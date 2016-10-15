<?php

namespace FileSystem\Disks;

use ArrayIterator;
use FileSystem\Disk;
use FileSystem\Exceptions\DiskAlreadyExistsException;
use FileSystem\Exceptions\DiskNotFoundException;
use IteratorAggregate;

class Manager implements IteratorAggregate
{
	private $disks = array ( );

	public function add ( Disk $disk )
	{
		if ( $this->has ( $disk->name ) )
			throw new DiskAlreadyExistsException ( $disk );
		$this->disks [ $disk->name ] = $disk;
	}

	public function get ( $name ) : Disk
	{
		if ( ! $this->has ( $name ) )
			throw new DiskNotFoundException ( $name );
		return $this->disks [ $name ];
	}

	public function has ( $name ) : bool
	{
		return ( bool ) ( array_key_exists ( $name, $this->disks ) );
	}

	public function getIterator ( ) : ArrayIterator
	{
		return new ArrayIterator ( $this->disks );
	}
}