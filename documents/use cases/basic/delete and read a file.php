<?php

use FileSystem\FileSystem;
use FileSystem\File;


when ( 'i want to delete a file', then( apply ( a ( function ( FileSystem $fileSystem, File $file )
{
	$fileSystem->delete ( $file );
	echo $file->content;
} ) ) ) );


/*
|--------------------------------------------------------------------------
| Note: The file stays intact.
|--------------------------------------------------------------------------
|
| After you call delete with $file on the file system it goes
| through the delete process of the file system, it is being 
| removed from the file tree and it is removed from the 
| parent inside the file tree. 
|
| BUT: The file stays intact, all its data and even the parent
| will stay intact meaning you can do with that file whatever
| you want.
*/