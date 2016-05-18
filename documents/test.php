<?php

/*
|--------------------------------------------------------------------------
| Original
|--------------------------------------------------------------------------
*/
$directory = new Directory ( $container->make ( 'application path' ) );
	
foreach( $fileSystem->findFilesIn ( $directory ) as $file )
	if( $file->extension === 'php' )
		require_once $file;

/*
|--------------------------------------------------------------------------
| With driver
|--------------------------------------------------------------------------
*/
$fileSystem = new FileSystem;
$driver = new LocalFileSystem;
$directory = new Directory ( $container->make ( 'application path' ), $driver );
	
foreach( $fileSystem->findFilesIn ( $directory ) as $file )
	if( $file->extension === 'php' )
		require_once $file;

/*
|--------------------------------------------------------------------------
| With files injected
|--------------------------------------------------------------------------
*/

$files = $driver->find ( $container->make ( 'application path' ) );
$directory = new Directory ( $container->make ( 'application path' ), $files );
	
foreach( $fileSystem->findFilesIn ( $directory ) as $file )
	if( $file->extension === 'php' )
		require_once $file;



$fileSystem->findFilesIn ( 'directory/path' );

// file system generates file objects, not the directory


// THIS IS THE WAY!!!!!!!
abstract class Directory
{
	private $path = '';
	private $files = array ( );

	public function __construct ( $path )
	{
		if ( ! is_string ( $path ) or empty ( $path ) or ! is_dir( $path ) )
			throw new InvalidArgumentException ( 'you did not provide a string that can be resolved as a directory' );
		$this->path = $path;
		$this->files = $this->getFilesFrom ( $path );
	}

	public function __get ( $property )
	{
		if ( isset ( $this-> { $property } ) )
			return $this-> { $property };
	}

	/**
	 * Get all the files from this directory
	 * 
	 * @param  string $path 		The directory path
	 * @return array       		An array of file objects from files within this directory
	 */
	abstract protected function getFilesFrom ( $path ) : array;
}

class LocalFileSystemDirectory extends Directory
{
	protected function getFilesFrom ( $path )
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