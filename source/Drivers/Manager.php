<?php

namespace FileSystem\Drivers;

use FileSystem\Drive;
use FileSystem\Exceptions\DriveNotFoundException;

class Manager
{
	private $mapping = array ( );

	public function add ( $name, Drive $drive )
	{
		$this->mapping [ $name ] = $drive;
	}

	public function get ( $name )
	{
		if ( ! isset ( $this->mapping [ $name ] ) )
			throw new DriveNotFoundException ( $name );
		return $this->mapping [ $name ];
	}
}