<?php

namespace Lionar\FileSystem\Tests\Drivers;

use Lionar\FileSystem\Drivers\LocalFileSystem,
	Lionar\Testing\TestCase,
	Mockery,
	org\bovigo\vfs\vfsStream as VFS;

class LocalFileSystemTest extends TestCase
{
	private $root, $fileTree, $fileSystem = null;

    public function setUp()
    {
        $this->root = VFS::setup ( 'root' );
        VFS::newDirectory ( 'storage' )->at ( $this->root );
		$this->fileTree = Mockery::mock ( 'Lionar\\FileSystem\\FileTree' )->shouldIgnoreMissing ( );
		$this->fileSystem = new LocalFileSystem ( VFS::url ( 'root' ), $this->fileTree );
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
		$directory = Mockery::mock ( 'Lionar\\FileSystem\\Directory', array ( 'application' ) );
		
		$this->fileSystem->make ( $directory );
		assertThat ( $this->root->hasChild ( 'application' ), is ( true ) );
	}

	/**
	 * @test
	 */
	public function make_withDirectoryThatDoesNotExistOnTheFileSystem_callsFileTreeAddMethod ( )
	{
		$directory = Mockery::mock ( 'Lionar\\FileSystem\\Directory', array ( 'application' ) );
		$this->fileTree->shouldReceive ( 'add' )->once ( )->with ( $directory );		
		$this->fileSystem->make ( $directory );
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 */
	public function make_withDirectoryThatDoesExistOnTheFileSystem_throwsException ( )
	{
		$directory = Mockery::mock ( 'Lionar\\FileSystem\\Directory', array ( 'storage' ) );
		
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
		$file = Mockery::mock ( 'Lionar\\FileSystem\\File', array ( 'file.txt' ) )->shouldIgnoreMissing ( );

		$this->fileSystem->write ( $writtenContent, $file );
		assertThat ( file_get_contents ( VFS::url ( 'root/file.txt' ) ), is ( identicalTo ( $writtenContent ) ) );
	}

	/**
	 * @test
	 */
	public function write_withContentsAndAFile_callsFileWriteMethod ( )
	{
		$writtenContent = 'my new content that is awesome';
		$file = Mockery::mock ( 'Lionar\\FileSystem\\File', array ( 'file.txt' ) );
		$file->shouldReceive ( 'write' )->once ( )->with ( $writtenContent );
		$this->fileSystem->write ( $writtenContent, $file );
	}
}