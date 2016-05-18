<?php

namespace Lionar\FileSystem\Tests\Directories;

use 	Lionar\FileSystem\Directories\LocalDirectory,
	Lionar\FileSystem\File,
	Lionar\Testing\TestCase,
	org\bovigo\vfs\vfsStream as VfsStream;

class LocalDirectoryTest extends TestCase
{
	private $root = null;

	private $structure = array(
      		'Core' => array(
        			'AbstractFactory' => array(
          				'test.php'    => 'some text content',
          				'other.php'   => 'Some more text content',
          				'Invalid.csv' => 'Something else',
         			),
        			'AnEmptyFolder'   => array(),
        			'badlocation.php' => 'some bad content',
      		)
    	);

	public function setUp ( )
	{
		VfsStream::setup ( 'root' );
		$this->root = VfsStream::create ( $this->structure );
	}

	/**
	 * @test
	 */
	public function __construct_withExistentDirectory_setsFilesOnDirectoryObject ( )
	{
		$files = array ( 
		              new File ( 'vfs://root/Core\AbstractFactory\test.php' ),
		              new File ( 'vfs://root/Core\AbstractFactory\other.php' ),
		              new File ( 'vfs://root/Core\AbstractFactory\Invalid.csv' ),
		              new File ( 'vfs://root/Core\badlocation.php' ),
		);
		$directory = new LocalDirectory ( VfsStream::url ( 'root/Core' ) );
		assertThat( $directory->files, is ( arrayContainingInAnyOrder ( $files ) ) );
	}
}