<?php

use FileSystem\File;
use FileSystem\FileSystem;


when ( 'i want to rename a file', then ( apply ( a ( function ( FileSystem $fileSystem, File $file )
{
	$fileSystem->rename ( $file );
} ) ) ) );



/*
|--------------------------------------------------------------------------
| Notes: renaming behind the scenes.
|--------------------------------------------------------------------------
|
| Behind the scenes in your technical code you call:
| $file->renameTo ( 'new name' );
|
| The business code here can choose to save it to the file
| system as it has done in the above code. Other options
| might include just ignoring the technical provided name
| and renaming the file to something else.
*/
