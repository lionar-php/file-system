<?php

use FileSystem\Directory;
use FileSystem\File;
use FileSystem\FileSystem;

when ( 'i want to move a file', then( apply ( a ( function ( FileSystem $filesystem, Directory $directory, File $file )
{
	$filesystem->move ( $file, to ( $directory ) );
} ) ) ) );
