<?php

namespace Lionar\FileSystem\Tests;

use 	Lionar\FileSystem\Directories\LocalDirectory,
	Lionar\FileSystem\File,
	Lionar\FileSystem\FileSystem,
	Lionar\Testing\TestCase,
	org\bovigo\vfs\vfsStream as VfsStream;

class FileSystemTest extends TestCase
{
	private $fileSystem = null;
	private $directoryStructure = array (
             		'dashboard.php' => '',
             		'blog' => array (
                		'post.php' => '',
                		'author.php' => '',
                		'permissions' => array (
                		                        'authors permissions.php' => ''
                		),
             		)
	);

	public function setUp ( )
	{
		VfsStream::setup ( 'root' );
		$root = VfsStream::create ( $this->directoryStructure );
		$this->fileSystem = new FileSystem;
	}

	/**
	 * @test
	 */
	public function findFilesIn_withExistentDirectoryForDirectoryArgument_returnsAllFilesInThatDirectory ( )
	{
		$allFilesInDirectory =  array ( new File ( 'vfs://root/blog\post.php' ), new File ( 'vfs://root/blog\author.php' ), new File ( 'vfs://root/blog\permissions\authors permissions.php' ) );
		$directory = new LocalDirectory ( VfsStream::url ( 'root/blog' ) );

		$files = $this->fileSystem->findFilesIn ( $directory );
		assertThat ( $files, is ( equalTo( $allFilesInDirectory ) ) );
	}

	/**
	 * @test
	 */
	public function findFilesDirectlyIn_withExistentDirectoryForDirectoryArgument_returnsAllFilesDirectlyInThatDirectory ( )
	{
		$allFilesInDirectory =  array ( new File ( 'vfs://root/blog\post.php' ), new File ( 'vfs://root/blog\author.php' ), new File ( 'vfs://root/blog\permissions\authors permissions.php' ) );
		$expectedFiles =  array ( new File ( 'vfs://root/blog\post.php' ), new File ( 'vfs://root/blog\author.php' ) );


		$directory = new LocalDirectory ( VfsStream::url ( 'root/blog' ) );
		$files = $this->fileSystem->findFilesDirectlyIn ( $directory );
		assertThat ( $files, is ( equalTo( $expectedFiles ) ) );
	}
}