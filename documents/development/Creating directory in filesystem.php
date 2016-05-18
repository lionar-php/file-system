<?php

namespace Lionar\FileSystem\Directories;

use 	InvalidArgumentException,
	Lionar\FileSystem\Directory,
	Lionar\FileSystem\File,
	RecursiveDirectoryIterator,
	RecursiveIteratorIterator;

class LocalDirectory extends Directory
{
	public function __construct ( $path )
	{
		parent::__construct ( $path );
		if ( ! file_exists ( $path ) or ! is_dir ( $path ) )
			mkdir ( $path );
	}

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