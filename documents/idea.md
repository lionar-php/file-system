# Big idea

Link file tree to a file system. file tree looks for all the changes in file system objects and on destruct persists them to the file system that is linked to it.

```php

<?php

interface Storage
{
    public function read ( ) : array
}

class FileTree
{
    private $fileSystem, $storage = null;
    private $objects, $actions = array ( );

    public function __construct ( FileSystem $fileSystem, Storage $storage )
    {
        $this->fileSystem = $fileSystem;
        $this->storage = $storage;
        $this->objects = $storage->read ( );
    }

    public function add ( Object $object )
    {
        $this->objects [ ] = $object;
    }

    public function __destruct ( )
    {
        // read object actions
        // update on $this->fileSystem
        // save changes to storage
    }
}

// local file system setup
// you will always use file system instance
$localFileSystem = new LocalFileSystem;
$fileTree = new FileTree ( $localFileSystem, $storage );
$fileSystem = new FileSystem ( $fileTree );


$fileSystem->write ( new Directory ( 'application' ) );





// every directory will automatically be added to a file tree
$container->bind ( 'Lionar\\FileSystem\\Directory', function ( )
{
    $directory = new Directory ( 'inputed directory name' );
    $fileTree->add ( $directory );
} );



$directory = $container->make ( 'Lionar\\FileSystem\\Directory' );
$directory->moveTo ( $root ); // file tree can detect