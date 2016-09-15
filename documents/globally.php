<?php

$objects = array (

	'application' 	=> new Directory ( 'application' ),
	'themes' 		=> new Directory ( 'themes' ),
	'dashboard'		=> new File ( 'dashboard.php', $objects [ 'themes' ] ),
);

$fileSystem = new LocalFileSystem ( __DIR__ );
$fileSystem->write ( 'my contents', to ( new File ( 'dashboard.php' ) ) );

$dashboard = $fileSystem->findFileAt ( '/dashboard.php' );
$dashboard->write ( 'cool contents' );