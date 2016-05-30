<?php

use Lionar\FileSystem\Directory,
	Lionar\FileSystem\File;

require __DIR__ . '/../vendor/autoload.php';

$lionare = new Directory ( 'lionare' );
$application = new Directory ( 'application' );
$storage = new Directory ( 'storage' );


$dashboard = new File ( 'dashboard.php' );
$application->add ( $dashboard );
$dashboard->write ( 'my contents' );
var_dump($application);
// var_dump($dashboard->path);

// $application->moveTo ( $lionare );

// var_dump($application->path);

// var_dump($dashboard);	
