<?php

use FileSystem\Directory;
use FileSystem\FileSystem;
use FileSystem\Location;

when ( 'i want to make a new directory', then( apply ( a ( function ( FileSystem $fileSystem, Directory $directory, Location $location )
{
	$fileSystem->make ( $directory, inside ( $location ) );
} ) ) ) );