<?php

namespace FileSystem\Exceptions;

use Exception;

class InvalidObjectName extends Exception
{
	public function __construct ( $name )
	{
		parent::__construct ( "$name is not a valid object name, the name of an object may not contain slashes" );
	}
}