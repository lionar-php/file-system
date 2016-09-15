<?php

use FileSystem\Directory;
use FileSystem\File;
use FileSystem\FileSystems\Dropbox;
use FileSystem\FileSystems\LocalFileSystem;

$fileSystem = new LocalFileSystem ( __DIR__ );
$dropbox = new Dropbox ( 'htpp://dropbox.com/aron' );

$file = new File ( 'dashboard.php' );
$file->write ( 'my contents' );

$fileSystem->write ( $file ); // one clone for file system
$dropbox->write ( $file ); // one clone for drop box

$application = new Directory ( 'application' );

$fileSystem->make ( $application );

// throw exception if directory where moved to does not exist
$fileSystem->move ( $file, to ( $application ) ); // file system clone moved to application