<?php

use Lionar\FileSystem\Directory,
	Lionar\FileSystem\File,
	Lionar\FileSystem\FileTree;

$application = new Directory ( 'application' );
$sports = new Directory ( 'sports', $application );
$storage = new Directory ( 'storage' );
$themes = new Directory ( 'themes' );
$dashboard = new File ( 'dashboard.php', $application );
$exercise = new File ( 'exercise.txt', $sports );


$fileTree = new FileTree;
$fileTree->add ( $application );
$fileTree->add ( $sports );
$fileTree->add ( $storage );
$fileTree->add ( $themes );
$fileTree->add ( $dashboard );
$fileTree->add ( $exercise );

return $fileTree;