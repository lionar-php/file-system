<?php

namespace FileSystem\Exceptions;

use Exception;
use FileSystem\Object;

class ObjectAlreadyExistsException extends Exception
{
	public function __construct ( Object $object )
	{
		parent::__construct ( "Object: $object->name already exists." );
	}
}