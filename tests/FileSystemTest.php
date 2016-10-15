<?php

namespace FileSystem\Tests;

use FileSystem\FileSystem;
use Mockery;
use Testing\TestCase;

class FileSystemTest extends TestCase
{
	private $fileSystem, $fileTree, $manager, $directory, $file = null;

	public function setUp ( )
	{
		$this->directory = Mockery::mock ( 'FileSystem\\Directory' )->shouldIgnoreMissing ( );
		$this->file = Mockery::mock ( 'FileSystem\\File' )->shouldIgnoreMissing ( );
		$this->fileTree = Mockery::mock ( 'FileSystem\\FileTree' )->shouldIgnoreMissing ( );
		$this->manager = Mockery::mock ( 'FileSystem\\Manager' )->shouldIgnoreMissing ( );
		$this->fileSystem = new FileSystem ( $this->fileTree, $this->manager );
	}

	/*
	|--------------------------------------------------------------------------
	| Make
	|--------------------------------------------------------------------------
	*/

	/**
	 * @test
	 */
	public function make_withDirectory_callsFileTreeAddMethod ( )
	{
		$this->fileTree->shouldReceive ( 'add' )->once ( )->with ( $this->directory );		
		$this->fileSystem->make ( $this->directory );
	}

	/**
	 * @test
	 */
	public function make_withDirectory_callsManagerMakeMethod ( )
	{
		$this->manager->shouldReceive ( 'make' )->with ( $this->directory )->once ( );
		$this->fileSystem->make ( $this->directory );
	}

	/**
	 * @test
	 */
	public function make_withDirectoryAndParentDirectory_callsParentAddMethod ( )
	{
		$parent = Mockery::mock ( 'FileSystem\\Directory' );
		$parent->shouldReceive ( 'add' )->with ( $this->directory )->once ( );
		$this->fileSystem->make ( $this->directory, $parent );
	}

	/*
	|--------------------------------------------------------------------------
	| Write
	|--------------------------------------------------------------------------
	*/

	/**
	 * @test
	 */
	public function write_withContentAndFile_addsFileToFileTree ( )
	{
		$this->fileTree->shouldReceive ( 'add' )->with ( $this->file )->once ( );
		$this->fileSystem->write ( $this->file );
	}

	/**
	 * @test
	 */
	public function write_withDirectory_callsManagerWriteMethod ( )
	{
		$this->manager->shouldReceive ( 'write' )->with ( $this->file )->once ( );
		$this->fileSystem->write ( $this->file );
	}

	/**
	 * @test
	 */
	public function write_withFileAndParentDirectory_callsParentAddMethod ( )
	{
		$parent = Mockery::mock ( 'FileSystem\\Directory' );
		$parent->shouldReceive ( 'add' )->with ( $this->file )->once ( );
		$this->fileSystem->write ( $this->file, $parent );
	}

	/*
	|--------------------------------------------------------------------------
	| Find files in
	|--------------------------------------------------------------------------
	*/

	/**
	 * @test
	 * @dataProvider objects
	 */
	public function findFilesIn_withDirectory_returnsAllFilesIncludingNestedFilesFromDirectory ( array $objects, array $expectedFiles )
	{
		$this->directory->objects = $objects;

		$files = $this->fileSystem->findFilesIn ( $this->directory );

		assertThat ( $files, is ( arrayContainingInAnyOrder ( $expectedFiles ) ) );
	}

	/*
	|--------------------------------------------------------------------------
	| Data providers
	|--------------------------------------------------------------------------
	*/

	public function objects ( )
	{
		$root = Mockery::mock ( 'FileSystem\\Root' )->shouldIgnoreMissing ( );
		$file = Mockery::mock ( 'FileSystem\\File[]', array ( 'file.txt', $root ) );
		$directory = Mockery::mock ( 'FileSystem\\Directory', array ( 'application', $root ) )->shouldIgnoreMissing ( );
		$nestedFile = Mockery::mock ( 'FileSystem\\File[]', array ( 'nested.txt', $directory ) );
		$directory->objects = array ( $nestedFile );

		return array (

			array ( array ( $file, $directory ), array ( $file, $nestedFile ) )
		);
	}
}