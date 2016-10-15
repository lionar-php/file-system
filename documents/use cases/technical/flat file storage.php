<?php

namespace FlatFile;

use FileSystem\File;
use FileSystem\FileSystem;

use function FileSystem\to;

class Store
{
	private $fileSystem, $file = null;

	public function __construct ( FileSystem $fileSystem, File $file )
	{
		$this->fileSystem = $fileSystem;
		$this->file = $file;
	}

	public function save ( $data )
	{
		if ( ! is_string ( $data ) )
			$data = serialize ( $data );
		$this->fileSystem->write ( $data, to ( $file ) );
	}
}