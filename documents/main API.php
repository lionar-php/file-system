<?php

$file = new File ( 'dashboard.php' );
$directory = new Directory ( 'application' );

$fileSystem->move ( $file, to ( $directory ) );
$fileSystem->write ( $file, inside ( $directory ) );



$file->write ( 'hello world' );
$fileSystem->write ( $file );