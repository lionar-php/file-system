<?php

use FileSystem\File;

when ( 'i want to read a file', then( apply ( a ( function ( File $file )
{
	echo $fileSystem->read ( $file );
} ) ) ) );
