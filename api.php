<?php

use Lionar\FileSystem\LocalFileSystem;

require __DIR__ . '/vendor/autoload.php';

$fileSystem = new LocalFileSystem ( __DIR__ );
$files = $fileSystem->findFilesIn ( 'tests' );

var_dump ( $files );



$directory = new Directory ( __DIR__ . '/source' );
echo $directory->path;