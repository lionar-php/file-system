<?php

use 	Lionar\FileSystem\Directory,
	Lionar\FileSystem\LocalFileSystem;

require __DIR__ . '/vendor/autoload.php';

$directory = new Directory ( __DIR__ . '/vendor' );
// echo $directory->path;
// var_dump($directory->files);

$fileSystem = new LocalFileSystem;
$files = $fileSystem->findFilesIn ( $directory );

var_dump ( $files );