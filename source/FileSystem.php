<?php

namespace Lionar\FileSystem;

abstract class FileSystem
{
	abstract public function make ( Directory $directory );

	abstract public function write ( $content, File $file );

	public function findFilesIn ( Directory $directory )
	{
		$files = array ( );

		foreach ( $directory->objects as $object )
		{
			if ( $object instanceOf File )
				$files [ ] = $object;
			else if ( $object instanceOf Directory )
				$files = array_merge ( $files, $this->findFilesIn ( $object ) );
		}

		return $files;
	}
}