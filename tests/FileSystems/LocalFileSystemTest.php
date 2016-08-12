<?php

namespace Lionar\FileSystem\Tests\FileSystems;

use Lionar\FileSystem\FileSystems\LocalFileSystem,
	Lionar\Testing\TestCase,
	Mockery,
	org\bovigo\vfs\vfsStream as VFS;

class LocalFileSystemTest extends TestCase
{
	private $root, $fileSystem = null;

    public function setUp()
    {
        $this->root = VFS::setup ( 'root' );
        VFS::newDirectory ( 'storage' )->at ( $this->root );
		$fileTree = Mockery::mock ( 'Lionar\\FileSystem\\FileTree[]' )->shouldIgnoreMissing ( );
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
		$directory = Mockery::mock ( 'Lionar\\FileSystem\\Directory', array ( VFS::url ( 'root' ) . '/application' ) );
		
		$this->fileSystem->make ( $directory );
		assertThat ( $this->root->hasChild ( 'application' ), is ( true ) );
	}

	/**
	 * @test
	 */
	public function make_withDirectoryThatDoesNotExistOnTheFileSystemWithParentDirectory_makesTheDirectoryInsideParent ( )
	{
		$parent = Mockery::mock ( 'Lionar\\FileSystem\\Directory', array ( VFS::url ( 'root' ) . '/application' ) )->shouldIgnoreMissing ( );
		$directory = Mockery::mock ( 'Lionar\\FileSystem\\Directory[]', array ( 'sports' ) )->shouldIgnoreMissing ( );
		
		$this->fileSystem->make ( $parent );
		$this->fileSystem->make ( $directory, $parent );
		assertThat ( file_exists ( VFS::url ( 'root' ) . '/application/sports' ), is ( true ) );
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 */
	public function make_withDirectoryThatDoesExistOnTheFileSystem_throwsException ( )
	{
		$directory = Mockery::mock ( 'Lionar\\FileSystem\\Directory', array ( VFS::url ( 'root' ) . '/storage' ) );
		
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
		$file = Mockery::mock ( 'Lionar\\FileSystem\\File[]', array ( VFS::url ( 'root' ) . '/file.txt' ) );

		$this->fileSystem->write ( $writtenContent, $file );
		assertThat ( file_get_contents ( VFS::url ( 'root/file.txt' ) ), is ( identicalTo ( $writtenContent ) ) );
	}
}