<?php

namespace Lionar\FileSystem;

use InvalidArgumentException;

abstract class Directory
{
	protected $path = '';
	protected $files = array ( );

	public function __construct ( $path )
	{
		if ( ! is_string ( $path ) or empty ( $path ) or ! is_dir( $path ) )
			throw new InvalidArgumentException ( 'you did not provide a string that can be resolved as a directory' );
		$this->path = $path;
		$this->files = $this->getFilesFrom ( $path );
	}

	public function __get ( $property )
	{
		if ( isset ( $this-> { $property } ) )
			return $this-> { $property };
	}

	abstract protected function getFilesFrom ( $path );
}