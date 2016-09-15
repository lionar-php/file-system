<?php

// once defined
$file = new File ( 'dashboard.php' );
$file->write ( 'my awesome contents' );


// multiple times used
$fileSystem->write ( $file );
$dropbox->write ( $file );



// how to now modify $file without fucking it up and making mismatches?

// this operation modifies the clone inside file system
$fileSystem->move ( $file, to ( $application ) );




$application->bind ( 'FileSystem\\File', function ( Input $input )
{
	$file = new File ( $input->get ( 'file name' ) );
	if ( input->has ( 'file content' ) )
		$file->write ( $input->get ( 'file content' ) );
	return $file;
} );


when ( 'i want to write a file', then( apply ( a ( function ( FileSystem $fileSystem, File $file )
{
	$fileSystem->write ( $file );	
} ) ) ) );



// what about internal checking if the file is still correct...


// we can use clones to make it look like we're using the same $file
echo $fileSystem->read ( $file );
require $fileSystem->pathTo ( $file );


// when we still want to write to that file we need to do this

$file->write ( 'new awesome contents' );
$fileSystem->write ( $file );

// things get out of hand.... we have moved this file around so it doesnt match any longer

// everything must be globally the same always and always
echo $file->content;
require $file;


