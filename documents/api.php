<?php

use 	Lionar\FileSystem\Directories\LocalDirectory as Directory,
	Lionar\FileSystem\File,
	Lionar\FileSystem\FileSystem;

require __DIR__ . '/../vendor/autoload.php';

$directory = new Directory ( __DIR__ . '/../source' );
// echo $directory->path;
// var_dump($directory->files);

$fileSystem = new FileSystem;
$files = $fileSystem->findFilesIn ( $directory );

var_dump ( $files );

$file = new File ( 'api.php', array ( 'title', 'paragraph' ) );
var_dump ( $file->contents );