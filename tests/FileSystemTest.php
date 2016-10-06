<?php

namespace FileSystem\Tests;

use FileSystem\FileSystem;
use	Mockery;
use Testing\TestCase;

class FileSystemTest extends TestCase
{
	private $fileSystem, $fileTree = null;

	public function setUp ( )
	{
		$this->fileTree = Mockery::mock ( 'FileSystem\\FileTree' )->shouldIgnoreMissing ( );
		$this->fileSystem = new FileSystem ( $this->fileTree );
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
		$directory = Mockery::mock ( 'FileSystem\\Directory', array ( 'application' ) );
		$this->fileTree->shouldReceive ( 'add' )->once ( )->with ( $directory );		
		$this->fileSystem->make ( $directory );
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
		$file = Mockery::mock ( 'FileSystem\\File' )->shouldIgnoreMissing ( );
		$this->fileTree->shouldReceive ( 'add' )->with ( $file )->once ( );
		$this->fileSystem->write ( $file );
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
		$directory = Mockery::mock ( 'FileSystem\\Directory' );
		$directory->objects = $objects;

		$files = $this->fileSystem->findFilesIn ( $directory );

		assertThat ( $files, is ( arrayContainingInAnyOrder ( $expectedFiles ) ) );
	}

	/*
	|--------------------------------------------------------------------------
	| Data providers
	|--------------------------------------------------------------------------
	*/

	public function objects ( )
	{
		$file = Mockery::mock ( 'FileSystem\\File[]', array ( 'file.txt' ) );
		$directory = Mockery::mock ( 'FileSystem\\Directory', array ( 'application' ) )->shouldIgnoreMissing ( );
		$nestedFile = Mockery::mock ( 'FileSystem\\File[]', array ( 'nested.txt', $directory ) );
		$directory->objects = array ( $nestedFile );

		return array (

			array ( array ( $file, $directory ), array ( $file, $nestedFile ) )
		);
	}
}