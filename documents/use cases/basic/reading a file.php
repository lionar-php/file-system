<?php

/*
|--------------------------------------------------------------------------
| Somewhere within your application.
|--------------------------------------------------------------------------
|
| This is just an example of what you can do. Input is the input the user of 
| your application provided.
*/

use FileSystem\File;

$application->bind ( 'FileSystem\\File', function ( Input $input )
{
    $file = new File ( $input->get ( 'name' ) );
    $file->write ( $input->get ( 'contents' ) );
    return $file;
} );



/*
|--------------------------------------------------------------------------
| Your business logic.
|--------------------------------------------------------------------------
*/
use FileSystem\File;

when ( 'i want to read a file', then( apply ( a ( function ( File $file )
{
    echo $file->contents;
} ) ) ) );
