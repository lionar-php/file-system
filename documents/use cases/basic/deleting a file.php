<?php

use FileSystem\FileSystem;
use FileSystem\File;


when ( 'i want to delete a file', then( apply ( a ( function ( FileSystem $fileSystem, File $file )
{
	$fileSystem->delete ( $file );
} ) ) ) );


// file is removed from the file system
// file is removed from the file tree
// file is removed from the file tree initial file parent
// 
// file still is in tact... meaning you can use it as normal, this doesnt matter at all
// its the developpers logic mistake if he thinks this file still exists in the file system