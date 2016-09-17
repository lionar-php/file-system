<?php

use FileSystem\Directory,
	FileSystem\File,
	FileSystem\FileTree,
	FileSystem\FileSystems\LocalFileSystem;

use function FileSystem\to;
use function FileSystem\inside;



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

$dashboard = new File ( 'dashboard.blade.php', $monastery );
$dashboard->write ( 'new dashboard contents' );
$fileSystem->write ( to ( $dashboard ) );
// $fileSystem->write ( "<h1>DASHBOARD FROM FILE SYSTEM LULLL</h1>", to ( $dashboard ) );



// let the file system get the files itself
// $files = $fileSystem->getFilesNamed ( 'dashboard.php' );

// foreach ( $files as $file )
// 	$fileSystem->append ( 'my content', to ( $file ) );




// $fileSystem->make ( $eyedouble, inside ( $themes ) );

$eyeDashboard = new File ( 'dashboard.blade.php' );
$eyeDashboard->write ( '<h1>Awesome eyedouble</h1>' );
$fileSystem->write ( $eyeDashboard, inside ( $eyedouble ) );