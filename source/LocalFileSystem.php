<?php

namespace Lionar\FileSystem;

use InvalidArgumentException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

class LocalFileSystem
{
	private $root = '';

	public function __construct ( $root )
	{
		if ( ! is_string ( $root ) or ! is_dir ( $root ) )
			throw new InvalidArgumentException ( 'you did not provide a valid root directory' );
		$this->root = $root;
	}

	public function findFilesIn ( $directory )
	{
		if ( ! is_string ( $directory ) or ! is_dir ( $directory = $this->root . '/' . $directory ) )
			throw new InvalidArgumentException ( 'you did not provide a valid directory' );
		$files = $this->filterFilesFrom ( $directory );

		foreach ( $files as $file )
			$return [ ] = new File ( $file->getPathname ( ) );

		return $return;
	}

	private function filterFilesFrom ( $directory )
	{
		$directory = new RecursiveDirectoryIterator( $directory );
  		$recursiveIterator = new RecursiveIteratorIterator($directory);
  		return new RegexIterator($recursiveIterator, '/^([^\.]|([^\.])\.[^\.])*$/' );
	}
}