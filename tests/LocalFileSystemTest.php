<?php

namespace Lionar\FileSystem\Tests;

use Lionar\FileSystem\File;
use Lionar\FileSystem\LocalFileSystem;
use Lionar\Testing\TestCase;
use org\bovigo\vfs\vfsStream as VfsStream;

class LocalFileSystemTest extends TestCase
{
	private $fileSystem = null;
	private $directoryStructure = array (
             		'dashboard.php' => '',
             		'blog' => array (
                		'post.php' => '',
                		'author.php' => ''
             		)
	);

	public function setUp ( )
	{
		VfsStream::setup ( 'root' );
		$root = VfsStream::create ( $this->directoryStructure );
		$this->fileSystem = new LocalFileSystem ( VfsStream::url( $root->getName ( ) ) );
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 * @dataProvider nonStringValues
	 */
	public function findFilesIn_withNonStringValue_throwsInvalidArgumentException ( $value )
	{
		$this->fileSystem->findFilesIn ( $value );
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 */
	public function findFilesIn_withNonExistentDirectory_throwsInvalidArgumentException ( )
	{
		$this->fileSystem->findFilesIn ( VfsStream::url( 'non existent directory' ) );
	}

	/**
	 * @test
	 */
	public function findFilesIn_withExistentDirectoryForDirectoryArgument_returnsAllFilesInThatDirectory ( )
	{
		
		$expectedFiles = array ( new File ( 'vfs://root/blog\post.php' ), new File ( 'vfs://root/blog\author.php' ) );
		$files = $this->fileSystem->findFilesIn ( 'blog' );

		assertThat( $files, is ( arrayContainingInAnyOrder ( $expectedFiles ) ) );
	}
}