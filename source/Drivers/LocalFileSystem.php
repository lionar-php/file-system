<?php

namespace Lionar\FileSystem\Drivers;

use InvalidArgumentException,
	Lionar\FileSystem\Directory,
	Lionar\FileSystem\File,
	Lionar\FileSystem\FileSystem,
	Lionar\FileSystem\FileTree,
	Lionar\FileSystem\Object;

class LocalFileSystem extends FileSystem
{
	private $root = '';
	private $fileTree = null;

	public function __construct ( $root, FileTree $fileTree )
	{
		$this->root = rtrim ( $root, '/' );
		$this->fileTree = $fileTree;
	}

	public function make ( Directory $newDirectory )
	{
		if ( file_exists ( $this->pathTo ( $newDirectory ) ) )
			throw new InvalidArgumentException ( 'That directory already exists' );
			
		mkdir ( $this->pathTo ( $newDirectory ) );
		$this->fileTree->add ( $newDirectory );
	}

	public function write ( $content, File $file )
	{
		file_put_contents ( $this->pathTo ( $file ), $content );
		$file->write ( $content );
	}

	private function pathTo ( Object $object )
	{
		return $this->root . '/' . $object->path;
	} 
}