<?php

namespace Lionar\FileSystem;

class FileSystem
{
	public function findFilesIn ( Directory $directory )
	{
		return $directory->files;
	}

	public function findFilesDirectlyIn ( Directory $directory ) : array
	{
		$files = array ( );

		foreach ( $directory->files as $file )
			if ( dirname ( $file ) === $directory->path )
				$files [ ] = $file;
			
		return $files;
	}
}