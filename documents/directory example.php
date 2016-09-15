<?php

// once defined
$directory = new Directory ( 'application' );

// used multiple times
$fileSystem->make ( $directory );
$dropbox->make ( $directory );


$fileSystem->has ( $directory );