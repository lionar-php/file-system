<?php

namespace FileSystem;

use InvalidArgumentException;

abstract class Driver
{
	abstract public function write ( File $file, $location );

	abstract public function make ( Directory $directory, $location );

	protected function correctify ( $location )
	{
		if ( ! is_string ( $location ) )
			throw new InvalidArgumentException ( '$location must be a string.' );
		return rtrim ( $location, '/' ) . '/';
	}
}