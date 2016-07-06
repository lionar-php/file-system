<?php

use	Lionar\FileSystem\Directory,
	Lionar\FileSystem\Drivers\LocalFileSystem,
	Lionar\FileSystem\File,
	Lionar\FileSystem\FileTree,
	Lionar\FileSystem\Object;

function to ( Object $object )
{
	return $object;
}

require __DIR__ . '/../vendor/autoload.php';
$fileTree = require __DIR__ . '/configuration/local file system root tree.php';

// var_dump( $fileTree );



$fileSystem = new LocalFileSystem ( __DIR__ . '/local file system root', $fileTree );
// $fileSystem->make ( new Directory ( 'themes' ) );
// $fileSystem->make ( $sports = new Directory ( 'sports', $application ) );

// $fileSystem->write ( 'my awesome contents', to ( new File ( 'exercise.txt', $sports ) ) );

// var_dump($fileTree); 

$fileSystem->write ( 'my trainer file', to ( new File ( 'trainer.php', $sports ) ) );
var_dump ( $fileSystem->findFilesIn ( $application ) );