<?php

namespace FileSystem\Exceptions;

use Exception;
use FileSystem\Disk;

class DiskAlreadyExistsException extends Exception
{
	public function __construct ( Disk $disk )
	{
		parent::__construct ( "Disk: $disk->name already exists." );
	}
}