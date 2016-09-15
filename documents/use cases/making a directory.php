<?php

use FileSystem\Directory;
use FileSystem\FileSystem;

when ( 'i want to make a directory', then( apply ( a ( function ( FileSystem $fileSystem, Directory $directory )
{
	$fileSystem->make ( $directory );
} ) ) ) );
