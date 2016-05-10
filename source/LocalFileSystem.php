<?php

namespace Lionar\FileSystem;

use InvalidArgumentException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

class LocalFileSystem
{
	public function findFilesIn ( Directory $directory )
	{
		$files = array ( );

		foreach ( $directory->files as $file )
			if ( dirname ( $file ) === $directory->path )
				$files [ ] = $file;
			
		return $files;
	}
}