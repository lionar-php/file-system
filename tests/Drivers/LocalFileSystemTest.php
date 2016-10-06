<?php

namespace FileSystem\Drivers\Tests;

use FileSystem\Drivers\LocalFileSystem;
use	Mockery;
use	org\bovigo\vfs\vfsStream as VFS;
use Testing\TestCase;

class LocalFileSystemTest extends TestCase
{
	private $root, $fileSystem = null;

    public function setUp()
    {
        $this->root = VFS::setup ( 'root' );
        VFS::newDirectory ( 'storage' )->at ( $this->root );
		$this->fileSystem = new LocalFileSystem;
    }

    /*
    |--------------------------------------------------------------------------
    | Making a directory.
    |--------------------------------------------------------------------------
    */

	/**
	 * @test
	 */
	public function make_withDirectoryThatDoesNotExistOnTheFileSystem_makesTheDirectory ( )
	{
		$directory = Mockery::mock ( 'FileSystem\\Directory', array ( 'application' ) );
		
		$this->fileSystem->make ( $directory, VFS::url ( 'root' ) );
		assertThat ( $this->root->hasChild ( 'application' ), is ( true ) );
	}

	/**
	 * @test
	 */
	public function make_withDirectoryThatDoesExistOnTheFileSystem_doesNotThrowExceptionOrError ( )
	{
		$directory = Mockery::mock ( 'FileSystem\\Directory', array ( 'storage' ) );
		
		$this->fileSystem->make ( $directory, VFS::url ( 'root' ) );
	}

    /*
	|--------------------------------------------------------------------------
	| Writing to a file.
	|--------------------------------------------------------------------------
	*/

	/**
	 * @test
	 */
	public function write_withContentsAndAFile_writesContentsToTheFileOnTheFileSystem ( )
	{
		$writtenContent = 'my new content that is awesome';
		$file = Mockery::mock ( 'FileSystem\\File[]', array ( 'file.txt' ) );
		$file->content = $writtenContent;

		$this->fileSystem->write ( $file, VFS::url ( 'root' ) );
		assertThat ( file_get_contents ( VFS::url ( 'root/file.txt' ) ), is ( identicalTo ( $writtenContent ) ) );
	}
}