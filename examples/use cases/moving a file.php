<?php

use FileSystem\Directory;
use FileSystem\File;
use FileSystem\FileSystem;

when ( 'i want to move a file', then( apply ( a ( function ( FileSystem $file, Directory $directory, File $file )
{
	$fileSystem->move ( $file, to ( $directory ) );
} ) ) ) );
