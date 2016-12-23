<?php

namespace FileSystem\Tools\Generators;

use InvalidArgumentException;
use FileSystem\Root;

class FileTreeGenerator
{
	public $rooted = array ( );

	public function add ( $directory )
	{
		if ( ! is_dir ( $directory ) )
			throw new InvalidArgumentException ( "$directory is not a valid directory." );
			
		$this->rooted [ $directory ] = new Root ( $directory );
	}
}