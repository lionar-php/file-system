<?php

namespace Lionar\FileSystem;

class LocalFileSystem implements FileSystem
{
	public function findFilesIn ( Directory $directory ) : array
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