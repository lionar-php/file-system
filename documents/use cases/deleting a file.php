<?php

use FileSystem\File;
use FileSystem\FileSystem;

when ( 'i want to delete a file', then( apply ( a ( function ( FileSystem $fileSystem, File $file )
{
	$fileSystem->delete ( $file );
} ) ) ) );
