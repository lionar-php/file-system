<?php

namespace FileSystem\Drivers\Tests;

use FileSystem\Drivers\LocalFileSystem;
use Mockery;
use org\bovigo\vfs\vfsStream as VFS;
use Testing\TestCase;

class LocalFileSystemTest extends TestCase
{
	private $root, $fileSystem = null;

	public function setUp()
	{
		$this->root = VFS::setup ( 'root' );
		VFS::newDirectory ( 'storage', 0777 )->at ( $this->root );
		VFS::newDirectory ( 'private', 0400 )->at ( $this->root );
		$this->fileSystem = new LocalFileSystem;
		$this->rootObject = Mockery::mock ( 'FileSystem\\Root' )->shouldIgnoreMissing ( );
	}

	/*
	|--------------------------------------------------------------------------
	| Making a directory.
	|--------------------------------------------------------------------------
	|
	| Make provides the functionality to make a directory inside a location ( path ).
	| Here we test if make correctly makes a directory when possible. Also we check 
	| that a NotWritableException is thrown when permission is denied.
	*/

	/**
	 * @test
	 */
	public function make_withDirectoryThatDoesNotExistOnTheFileSystem_makesTheDirectory ( )
	{
		$directory = Mockery::mock ( 'FileSystem\\Directory', array ( 'application', $this->rootObject ) );

		$this->fileSystem->make ( $directory, VFS::url ( 'root' ) );
		assertThat ( $this->root->hasChild ( 'application' ), is ( true ) );
	}

	/**
	 * @test
	 */
	public function make_withDirectoryThatDoesExistOnTheFileSystem_doesNotThrowExceptionOrError ( )
	{
		$directory = Mockery::mock ( 'FileSystem\\Directory', array ( 'storage', $this->rootObject ) );
		
		$this->fileSystem->make ( $directory, VFS::url ( 'root' ) );
	}

	/**
	 * @test
	 * @expectedException  FileSystem\Exceptions\NotWritableException
	 */
	public function make_withLocationThatIsNotWritable_throwsException ( )
	{
		$directory = Mockery::mock ( 'FileSystem\\Directory', array ( 'storage', $this->rootObject ) );
		
		$this->fileSystem->make ( $directory, VFS::url ( 'root/private' ) );
	}

	/*
	|--------------------------------------------------------------------------
	| Writing to a file.
	|--------------------------------------------------------------------------
	|
	| Write provides the functionality to write a file inside a location ( path ).
	| Here we test if write correctly writes a file when possible. Also we check 
	| that a NotWritableException is thrown when permission is denied.
	*/

	/**
	 * @test
	 */
	public function write_withContentsAndAFile_writesContentsToTheFileOnTheFileSystem ( )
	{
		$writtenContent = 'my new content that is awesome';
		$file = Mockery::mock ( 'FileSystem\\File[]', array ( 'file.txt', $this->rootObject ) );
		$file->content = $writtenContent;

		$this->fileSystem->write ( $file, VFS::url ( 'root' ) );
		assertThat ( file_get_contents ( VFS::url ( 'root/file.txt' ) ), is ( identicalTo ( $writtenContent ) ) );
	}

	/**
	 * @test
	 * @expectedException  FileSystem\Exceptions\NotWritableException
	 */
	public function write_withLocationThatIsNotWritable_throwsException ( )
	{
		$file = Mockery::mock ( 'FileSystem\\File[]', array ( 'file.txt', $this->rootObject ) );
		
		$this->fileSystem->write ( $file, VFS::url ( 'root/private' ) );
	}
}