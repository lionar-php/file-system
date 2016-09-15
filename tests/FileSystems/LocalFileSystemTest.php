<?php

namespace FileSystem\Tests\FileSystems;

use FileSystem\FileSystems\LocalFileSystem;
use	Testing\TestCase;
use	Mockery;
use	org\bovigo\vfs\vfsStream as VFS;

class LocalFileSystemTest extends TestCase
{
	private $root, $fileSystem = null;

    public function setUp()
    {
        $this->root = VFS::setup ( 'root' );
        VFS::newDirectory ( 'storage' )->at ( $this->root );
		$fileTree = Mockery::mock ( 'FileSystem\\FileTree[]' )->shouldIgnoreMissing ( );
		$this->fileSystem = new LocalFileSystem ( $fileTree );
    }

    /*
    |--------------------------------------------------------------------------
    | Making a directory
    |--------------------------------------------------------------------------
    */

	/**
	 * @test
	 */
	public function make_withDirectoryThatDoesNotExistOnTheFileSystem_makesTheDirectory ( )
	{
		$directory = Mockery::mock ( 'FileSystem\\Directory', array ( VFS::url ( 'root' ) . '/application' ) );
		
		$this->fileSystem->make ( $directory );
		assertThat ( $this->root->hasChild ( 'application' ), is ( true ) );
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 */
	public function make_withDirectoryThatDoesExistOnTheFileSystem_throwsException ( )
	{
		$directory = Mockery::mock ( 'FileSystem\\Directory', array ( VFS::url ( 'root' ) . '/storage' ) );
		
		$this->fileSystem->make ( $directory );
	}

	/*
	|--------------------------------------------------------------------------
	| Writing to a file
	|--------------------------------------------------------------------------
	*/

	/**
	 * @test
	 */
	public function write_withContentsAndAFile_writesContentsToTheFileOnTheFileSystem ( )
	{
		$writtenContent = 'my new content that is awesome';
		$file = Mockery::mock ( 'FileSystem\\File[]', array ( VFS::url ( 'root' ) . '/file.txt' ) );
		$file->write ( $writtenContent );

		$this->fileSystem->write ( $file );
		assertThat ( file_get_contents ( VFS::url ( 'root/file.txt' ) ), is ( identicalTo ( $writtenContent ) ) );
	}
}