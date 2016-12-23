<?php

namespace FileSystem\Drivers;

use FileSystem\Driver;
use FileSystem\Exceptions\DriveNotFoundException;

class Manager
{
	private $mapping = array ( );

	public function add ( $name, Driver $drive )
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