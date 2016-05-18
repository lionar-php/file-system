# Notes

If you want the file system to handle directory files nesting you need to inject them into the directory.


```php
<?php

interface Driver
{
	public function getFilesFrom ( $path );

	public function getDirectoriesFrom ( $path );
}

class LocalFileSystem implements Driver
{
	public function getFilesFrom ( $path )
	{
  		foreach ( new RecursiveIteratorIterator ( new RecursiveDirectoryIterator( $path ) ) as $fileName )
  		{
		    	if ( $fileName->isDir ( ) ) 
		    		continue;
		    	$files [ ] = new File ( ( string ) $fileName );
  		}
		return $files;
	}
}

class Directory
{
	public function __construct ( $path, array $files = array ( ), $directories = array ( ) )
	{
		$this->path = $path;
		$this->files = $files;
		$this->directories = $directories;
	}
}

class FileSystem
{	
	public function findFilesIn ( Directory $directory )
	{

	}
}
// weird way
$files = $driver->getFilesFrom ( '/hello/world' );
$directory = new Directory ( '/hello/world', $files ); 

$directory

//

$files = new Files;
$files->add ( $file );

$directory = new Directory ( '/hello/world', $files, $directories );

$driver = new LocalFileSystem ( __DIR__ );
$directory = new Directory ( '/hello/world', $driver );

class LocalDirectory
{
	private $path = '';
	private $files = array ( );

	public function __construct ( $path )
	{
		if ( ! is_string ( $path ) or empty ( $path ) or ! is_dir ( $path ) )
			throw new InvalidArgumentException ( 'you did not provide a string that can be resolved as a directory' );
		$this->path = $path;
		$this->files = $this->getFilesFrom ( $path );
	}

	public function __get ( $property )
	{
		if ( isset ( $this-> { $property } ) )
			return $this-> { $property };
	}

	private function getFilesFrom ( $path )
	{
  		foreach ( new RecursiveIteratorIterator ( new RecursiveDirectoryIterator( $path ) ) as $fileName )
  		{
		    	if ( $fileName->isDir ( ) ) 
		    		continue;
		    	$files [ ] = new File ( ( string ) $fileName );
  		}
		return $files;
	}
}

$directory = new LocalDirectory ( '/hello/world' );
$fileSystem = new LocalFileSystem ( __DIR__ );
$fileSystem->findFilesIn ( $directory );

$directory = new Directory ( __DIR__, $driver );
$directory->files;

class Directory
{
	private $listing = array (
		new Directory ( ),
		new File( )
		new Directory( )
	);
}

```

