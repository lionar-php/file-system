<?php

namespace Lionar\FileSystem;

use InvalidArgumentException;

interface FileSystem
{
	/**
	 * Find all the files inside a directory. This function searches nested directories too
	 * 
	 * @param  Directory $directory 	The directory to search files in
	 * @return array            		An array of files found in the directory
	 */
	public function findFilesIn ( Directory $directory );
}