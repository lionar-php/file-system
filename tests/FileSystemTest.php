<?php

namespace FileSystem\Tests;

use Testing\TestCase;
use	Mockery;

class FileSystemTest extends TestCase
{
	private $fileSystem, $fileTree = null;

	public function setUp ( )
	{
		$this->fileTree = Mockery::mock ( 'FileSystem\\FileTree' )->shouldIgnoreMissing ( );
		$this->fileSystem = Mockery::mock ( 'FileSystem\\FileSystem[]', array ( $this->fileTree ) );
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

	/**
	 * @test 
	 */
	public function make_withDirectoryAndParentDirectory_addsParentToDirectory ( )
	{
		$parent = Mockery::mock ( 'FileSystem\\Directory' )->shouldIgnoreMissing ( );
		$directory = Mockery::mock ( 'FileSystem\\Directory[]', array ( 'application' ) )->shouldIgnoreMissing ( );

		$this->fileTree->shouldReceive ( 'has' )->with ( $directory )->andReturn ( false );
		$this->fileTree->shouldReceive ( 'has' )->with ( $parent )->andReturn ( true );

		$this->fileSystem->make ( $directory, $parent );
		assertThat ( $directory->parent, is ( identicalTo ( $parent ) ) );	
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 */
	public function make_withParentDirectoryThatDoesNotExistOnTheFileTree_throwsException ( )
	{
		$nonExistentParent = Mockery::mock ( 'FileSystem\\Directory' );
		$this->fileTree->shouldReceive ( 'has' )->with ( $nonExistentParent )->andReturn ( false );
		$directory = Mockery::mock ( 'FileSystem\\Directory' );
		$this->fileSystem->make ( $directory, $nonExistentParent );
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
	
	/**
	 * @test
	 */
	public function write_withFileAndParentDirectory_addsParentToFile ( )
	{
		$parent = Mockery::mock ( 'FileSystem\\Directory' )->shouldIgnoreMissing ( );
		$file = Mockery::mock ( 'FileSystem\\File[]', array ( 'file.php' ) )->shouldIgnoreMissing ( );
		$this->fileTree->shouldReceive ( 'has' )->with ( $parent )->andReturn ( true );
		$this->fileSystem->write ( $file, $parent );
		assertThat ( $file->parent, is ( identicalTo ( $parent ) ) );
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 */
	public function write_withParentDirectoryThatDoesNotExistOnTheFileTree_throwsException ( )
	{
		$nonExistentParent = Mockery::mock ( 'FileSystem\\Directory' );
		$this->fileTree->shouldReceive ( 'has' )->with ( $nonExistentParent )->andReturn ( false );
		$file = Mockery::mock ( 'FileSystem\\File' )->shouldIgnoreMissing ( );
		$this->fileSystem->write ( $file, $nonExistentParent );
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