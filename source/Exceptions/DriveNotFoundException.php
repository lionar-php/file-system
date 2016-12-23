<?php

namespace FileSystem\Exceptions;

use Exception;

class DriveNotFoundException extends Exception
{
	public function __construct ( $name )
	{
		parent::__construct ( "A driver with the name: $name could not be found." );
	}
}