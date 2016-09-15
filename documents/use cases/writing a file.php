<?php

use FileSystem\File;
use FileSystem\FileSystem;

when ( 'i want to write a file', then( apply ( a ( function ( FileSystem $fileSystem, File $file )
{
	$fileSystem->write ( $file );
} ) ) ) );