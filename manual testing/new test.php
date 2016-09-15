<?php

use FileSystem\Directory,
	FileSystem\File,
	FileSystem\FileTree,
	FileSystem\FileSystems\LocalFileSystem;

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
// $fileSystem->write ( 'hellooo', to ( new File ( 'dashboard.blade.php', $monastery ) ) );
// $fileSystem->write ( "<h1>DASHBOARD FROM FILE SYSTEM LULLL</h1>", to ( $dashboard ) );



// let the file system get the files itself
// $files = $fileSystem->getFilesNamed ( 'dashboard.php' );

// foreach ( $files as $file )
// 	$fileSystem->append ( 'my content', to ( $file ) );




// $fileSystem->make ( $eyedouble, inside ( $themes ) );

$eyeDashboard = new File ( 'dashboard.blade.php', $eyedouble );
$eyeDashboard->write ( '<h1>Eyedouble template</h1>' );
$fileSystem->write ( $eyeDashboard );