<?php

namespace FileSystem\Exceptions;

use Exception;
use FileSystem\Object;

class ObjectNotFoundException extends Exception
{
	public function __construct ( Object $object )
	{
		$message = "The object at path: $object->path does not exist.";
		parent::__construct ( $message );
	}
}