<?php

$directories = new DirectoryCollection ( $storage->read ( 'directories' ) );
$directory = new SingleDirectoryFinder ( $directories );

if ( $directories->has ( $directory->identifiedBy ( __DIR__ ) ) )
	$root = $directory->identifiedBy ( __DIR__ );
else
	$root = new Directory ( __DIR__ );

$fileSystem = new LocalFileSystem ( $root, $directories, $files );
$fileSystem->make ( new Directory ( 'application' ), inside ( $root ) );




$container->bind ( 'Directory', function ( Input $inputed )
{
	return new Directory ( $inputed->name );
} );

when ( 'i want to make a new directory', then( apply ( a ( 
	function ( FileSystem $fileSystem, Directory $newDirectory, SingleDirectoryFinder $directory )
{
	$fileSystem->make ( $newDirectory, inside ( $directory->named ( 'my documents' ) ) );
}))));

when ( 'i want to move a directory', then( apply ( a ( 
	function ( FileSystem $fileSystem, DirectoryToMove $directory, NewDirectoryParent $parent )
{
	$fileSystem->move ( $directory, to ( $parent ) );
}))));

$container->bind ( 'DirectoryToMove', function ( Input $input, SingleDirectoryFinder $directory )
{
	return $directory->named ( $input->directory );
} );

$container->bind ( 'NewDirectoryParent', function ( Input $input, SingleDirectoryFinder $directory )
{
	return $directory->named ( $input->parent );
} );

when ( 'i want to move a directory', then( apply ( a ( function ( FileSystem $fileSystem, SingleDirectoryFinder $directory )
{
	$directoryToMove = $directory->named ( $inputted->name );
	$parent = $directory->named ( $inputted->parent );
	$fileSystem->move ( $directoryToMove, to ( $parent ) );
}))));

when ( 'i want to move a directory', then( apply ( a ( function ( FileSystem $fileSystem, Directory $directory, Directory $parent )
{
	$fileSystem->move ( $directory, to ( $parent ) );
}))));

$container->describe ( 'i want to move a directory', 
	function ( closure $action, FileSystem $fileSystem, SingleFileFinder $directory, Input $inputted )
{
	$parent = $directory->named ( $inputted->parent );
	$directory = $directory->named ( $inputted->directory );

	call_user_func_array ( $action, array ( $fileSystem, $directory, $parent ) );
} );
