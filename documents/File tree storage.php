<?php

class FileTree
{
	public function __construct ( array $fileSystemObjects = array ( ) )
	{
		$this->objects = $fileSystemObjects;
	}

	public function add ( Object $object )
	{
		if ( ! $this->has ( $object ) )
			$this->objects [ $object->path ] = $object;
	}
}

$objects = $storage->read ( );
$fileTree = new FileTree ( $objects );
$fileTree->add ( new File ( 'my file.php' ) );
$storage->save ( $fileTree->objects );

$fileFinder = new FileFinder ( $fileTree );
$fileFinder->findFilesNamed ( 'dashboard.php' );


when ( 'i want to find a file by name', then ( apply ( a ( function ( FileFinder $file )
{
	// this will not happen likely because file system is something technical
	$file = $file->named ( 'dashboard.php' );
	$fileSystem->move ( $file, to ( $directory ) );
}))));