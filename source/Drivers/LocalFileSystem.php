<?php

namespace FileSystem\Drivers;

use FileSystem\Directory;
use FileSystem\Driver;
use FileSystem\Exceptions\NotWritableException;
use FileSystem\File;

class LocalFileSystem extends Driver
{
	public function write ( File $file, $location )
	{
		$this->permissionCheck ( $location . $file->parent->path );
		$location = $this->correctify ( $location );
		file_put_contents ( $location . $file->path, $file->content );
	}

	public function make ( Directory $directory, $location )
	{
		$location = $this->correctify ( $location );
		if ( is_dir ( $location . $directory->path ) )
			return;

		$this->permissionCheck ( $location . $directory->parent->path );
		mkdir ( $location . $directory->path );
	}

	private function permissionCheck ( $location )
	{
		if ( ! is_writable ( $location ) )
			throw new NotWritableException ( $location );
	}
}