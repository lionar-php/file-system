<?php

namespace FileSystem;

class FileSystem
{
	private $objects = array ( );

	public function write ( File $file )
	{
		$file = clone $file;
		$this->objects [ $file->key ] = $file;
	}

	public function make ( Directory $directory )
	{
		$directory = clone $directory;
		$this->objects [ $directory->key ] = $directory;
	}

	public function move ( File $file, Directory $parent )
	{
		$this->objects [ $file->key ]->moveTo ( $this->objects [ $parent->key ] );
	}
}