<?php

class Directory
{
	private $name = '';
	private $parent = null;
	private $directories, $files = array ( );

	public function __construct ( $name, Directory $parent = null )
	{
		$this->name = $name;

		if ( ! is_null ( $parent ) )
			$parent->add ( $this );

		$this->parent = $parent;
	}

	public function add ( Object $object )
	{
		if ( $object instanceOf Directory )
			$this->directories [ ] = $object;
		else
			$this->file ( $object );
	}

	public function hasFile ( File $file )
	{
		return in_array ( $object, $this->files );
	}

	private function file ( File $file )
	{
		if ( ! $this->hasFile ( $file ) )
			$this->files [ ] = $object;
		
		if ( ! $file->parent === $this )	
			$object->moveTo ( $this );
	}
}












when ( 'i want to find files inside a directory', then ( apply ( a ( function ( FileSystem $fileSystem )
{
	// here you inject the collections inside file system
	$directory = $fileSystem->findDirectoryAtPath ( 'root/application' );
	$fileSystem->findFilesIn ( $directory );

}))));


// chosen for now..
when ( 'i want to find files inside a directory', then ( apply ( a ( function ( FileSystem $fileSystem, Collection $directory )
{
	// here you just use file system as an ease of use wrapper
	$fileSystem->findFilesIn ( $directory->withPath ( 'root/application' ) );

}))));