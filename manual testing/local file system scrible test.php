<?php

require __DIR__ . '/../vendor/autoload.php';

// readability
function to ( Object $object )
{
	return $object;
}

$fileSystem = new LocalFileSystem ( __DIR__ );
$root = $fileTree->findDirectoryAtPath ( '/' );

$fileSystem->find->FilesIn ( $root );
$fileSystem->find->FilesDirectlyIn ( $root );
$fileSystem->find->directoryAtPath ( '/' );


$file = $fileTree->findFileAtPath ( 'application/dashboard.php' );
$fileSystem->write ( 'my contents', to ( $file ) ); // locally this file now reflects the object.
$fileSystem->read ( $file );

$dropbox->write ( $file );
$dropbox->read ( $file );
$dropbox->findFilesIn ( $root );


foreach ( $fileTree->objects as $object )
	$fileSystem->make ( $object );



array (

	'application file tree on the local file system',
	'storage file tree on the local file system',

	'application file tree on dropbox',
	'storage file tree on dropbox'
);

// 1. you must never randomly use one file tree on another file system
// 2. must the file tree always be in sync with the file system?
// 		yes, else you can find files that do not actually exist on the file system
// 		or miss files that actually do exist on the file system
// 		


$fileSystem->fileTree->findFileAtPath ( '/' );

// or

$finder = new Finder ( $fileTree );
$file = $finder->findFileAtPath ( '/' );
$fileSystem->write ( 'my contents', to ( $file ) );



// how to ensure that we don't mix file tree's?

$fileSystem = new LocalFileSystem ( __DIR__ ); // work from this point