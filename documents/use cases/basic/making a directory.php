<?php

use FileSystem\Directory;
use FileSystem\FileSystem;


when ( 'i want to make a new directory', then( apply ( a ( function ( FileSystem $fileSystem, Directory $directory )
{
	$fileSystem->make ( $directory );
} ) ) ) );