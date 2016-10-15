# Use cases

The uses cases in this directory use a pattern of closures which looks like the following:

```php
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
```

Inside the closure the specific dependency is injected by a container. In this case an instance of FileSystem\File is injected. How it is injected is decided by the container, which is occasionally also shown in the examples to give you a clear view of how you would use this library inside your business logic. In this case you see this declared above the closure.