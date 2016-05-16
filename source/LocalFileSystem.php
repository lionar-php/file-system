<?php

namespace Lionar\FileSystem;

class LocalFileSystem
{
	public function findFilesIn ( Directory $directory )
	{
		return $directory->files;
	}
}