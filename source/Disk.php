<?php

namespace FileSystem;

use Accessibility\Readable;
use InvalidArgumentException;

class Disk
{
	use Readable;

	private $name, $location = '';
	private $driver = null;

	public function __construct ( $name, $location, Driver $driver )
	{
		$this->name = $this->named ( $name );
		$this->location = $this->located ( $location );
		$this->driver = $driver;
	}

	public function make ( Directory $directory )
	{
		$this->driver->make ( $directory, at ( $this->location ) );
	}

	public function write ( File $file )
	{
		$this->driver->write ( $file, at ( $this->location ) );
	}

	private function named ( $name )
	{
		if ( ! is_string ( $name ) or empty ( $name ) )
			throw new InvalidArgumentException ( '$name must be a non empty string.' );
		return $name;
	}

	private function located ( $location )
	{
		if ( ! is_string ( $location ) )
			throw new InvalidArgumentException ( '$location must be a string.' );
		return $location;
	}
}