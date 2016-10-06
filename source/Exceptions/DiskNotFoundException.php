<?php

namespace FileSystem\Exceptions;

use Exception;

class DiskNotFoundException extends Exception
{
	public function __construct ( $name )
	{
		parent::__construct ( "Disk: $name could not be found." );
	}
}