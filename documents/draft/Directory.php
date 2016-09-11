<?php

namespace FileSystem;

class Directory
{
	protected $isReadable = true;
	protected $isWritable = false;
	protected $name = '';

	public function __construct ( $name, $isReadable = true, $isWritable = false )
	{
		$this->name = $name;
		$this->isReadable = $isReadable;
		$this->isWritable = $isWritable;
	}

	public function __get ( $property )
	{
		if ( isset ( $this-> { $property } ) )
			return $this-> { $property };
	}
}

class LocalDirectory
{
	public function isReadable ( )
	{
		return is_readable ( $this->path );
	}

	public function isWritable ( )
	{
		return is_writable ( $this->path );
	}
}

$templates = new LocalFileTree;
$templates->add ( new LocalFile (  ) )