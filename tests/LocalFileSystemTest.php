<?php

namespace Lionar\FileSystem\Tests;

use 	Lionar\FileSystem\File,
	Lionar\FileSystem\LocalFileSystem,
	Lionar\Testing\TestCase,
	Mockery,
	org\bovigo\vfs\vfsStream as VfsStream;

class LocalFileSystemTest extends TestCase
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
		$this->fileSystem = new LocalFileSystem;
	}

	/**
	 * @test
	 */
	public function findFilesIn_withExistentDirectoryForDirectoryArgument_returnsAllFilesInThatDirectory ( )
	{
		$allFilesInDirectory =  array ( new File ( 'vfs://root/blog\post.php' ), new File ( 'vfs://root/blog\author.php' ), new File ( 'vfs://root/blog\permissions\authors permissions.php' ) );
		
		$directory = Mockery::mock ( 'Lionar\\FileSystem\\Directory', array ( VfsStream::url ( 'root/blog' ) ) );
		$directory->files = $allFilesInDirectory;
		$files = $this->fileSystem->findFilesIn ( $directory );
		assertThat ( $files, is ( equalTo( $allFilesInDirectory ) ) );
	}
}