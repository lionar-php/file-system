<?php

namespace FileSystem\Rules;

use Accessibility\Readable;
use FileSystem\Directory;
use InvalidArgumentException;

class Rule
{
	use Readable;

	private $name, $description = '';
	private $acceptedTypes = array ( 'objects', 'directories', 'files' );
	private $directory = null;

	public function __construct ( $name, $description, $type, Directory $directory )
	{
		$this->name = $this->check ( $name, 'name' );
		$this->description = $this->check ( $description, 'description' );
		$this->type = $this->inspect ( $type );
		$this->directory = $directory;
	}

	private function check ( $value, $property )
	{
		if ( ! is_string ( $value ) or empty ( $value ) )
			throw new InvalidArgumentException ( "$property must be a non empty string" );
		return $value;
	}

	private function inspect ( $type )
	{
		if ( ! in_array ( $type, $this->acceptedTypes ) )
			throw new InvalidArgumentException ( ( string ) $type . 
				' is not accepted, it must be one of: objects, directories or files' );
		return $type;
	}
}