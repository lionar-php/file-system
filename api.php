<?php

use Lionar\FileSystem\LocalFileSystem;

require __DIR__ . '/vendor/autoload.php';

$directory = new Directory ( __DIR__ . '/source' );
echo $directory->path;


$fileSystem = new LocalFileSystem;
$files = $fileSystem->findFilesIn ( $directory );

var_dump ( $files );