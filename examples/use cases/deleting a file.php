<?php

use FileSystem\FileSystem;
use FileSystem\File;

when ( 'i want to delete a file', then( apply ( a ( function ( FileSystem $fileSystem, File $file )
{
	$fileSystem->delete ( $file );
} ) ) ) );