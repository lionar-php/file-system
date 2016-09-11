<?php

use Lionar\FileSystem\Directory,
	Lionar\FileSystem\File,
	Lionar\FileSystem\FileTree,
	Lionar\FileSystem\FileSystems\LocalFileSystem;

function to ( File $file )
{
	return $file;
}

function inside ( Directory $directory )
{
	return $directory;
}

require __DIR__ . '/../vendor/autoload.php';

$objects = array ( 
	$root = new Directory ( __DIR__ . '/root' ),
	$themes = new Directory ( 'themes', $root ),
	$monastery = new Directory ( 'monastery', $themes ),
	$dashboard = new File ( 'dashboard.blade.php', $monastery ),
	$eyedouble = new Directory ( 'eyedouble', $themes ),
);

$fileTree = new FileTree;

foreach ( $objects as $object )
	$fileTree->add ( $object );

$fileSystem = new LocalFileSystem ( $fileTree );
// $fileSystem->write ( "<h1>DASHBOARD FROM FILE SYSTEM LULLL</h1>", to ( $dashboard ) );




// $fileSystem->make ( $eyedouble, inside ( $themes ) );

$eyeDashboard = new File ( 'dashboard.blade.php' );
$fileSystem->write ( '<h1>Eyedouble\'s template yeah!</h1>', to ( $eyeDashboard ), inside ( $eyedouble ) );