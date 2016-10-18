<?php

namespace FileSystem\Exceptions;

use Exception;
use FileSystem\Object;

class NotWritableException extends Exception
{
	public function __construct ( $location )
	{
		parent::__construct ( "Permission is denied to write to $location." );
	}
}

