<?php

namespace FileSystem\Drivers;

use FileSystem\Directory;
use FileSystem\Driver;
use FileSystem\File;

class LocalFileSystem extends Driver
{
	public function write ( File $file, $location )
	{
		$location = $this->correctify ( $location );
		file_put_contents ( $location . $file->path, $file->content );
	}

	public function make ( Directory $directory, $location )
	{
		$location = $this->correctify ( $location );
		if ( is_dir ( $location . $directory->path ) )
			return;
		mkdir ( $location . $directory->path );
	}
}