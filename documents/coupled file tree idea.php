<?php

use FileSystem\FileSystem;

$application->share ( 'FileSystem\\FileSystem', function ( )
{
	
	return new FileSystem ( $fileTree );
} );