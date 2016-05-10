<?php

namespace Lionar\FileSystem;

use 	InvalidArgumentException,
	RecursiveDirectoryIterator,
	RecursiveIteratorIterator;

class Directory
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