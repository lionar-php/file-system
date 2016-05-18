<?php

namespace Lionar\FileSystem\Directories;

use 	InvalidArgumentException,
	Lionar\FileSystem\Directory,
	Lionar\FileSystem\File,
	RecursiveDirectoryIterator,
	RecursiveIteratorIterator;

class LocalDirectory extends Directory
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