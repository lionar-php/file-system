<?php

namespace FileSystem;

class File
{
	private $key = '';

	public function __construct ( )
	{
		$this->key = uniqid ( );
	}

	public function __get ( $property )
	{
		if ( isset ( $this-> { $property } ) )
			return $this-> { $property };
	}
}