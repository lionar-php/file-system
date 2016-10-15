<?php

/**
 * Somewhere within your application:
 * 
 * This is just an example of what you can do.
 */
namespace FileSystem;


class Space extends Directory
{
	
}


$application->bind ( 'FileSystem\\Space', function ( User $user )
{
	return new Space ( $user->allocatedSpacePath );
} );


// In your business logic:

use FileSystem\File;
use FileSystem\FileSystem;
use FileSystem\Space;


when ( 'i want to make a directory inside my space', 

then( apply ( a ( function ( FileSystem $fileSystem, Space $space, File $file )
{
	$fileSystem->write ( $file, inside ( $space ) );
} ) ) ) );
