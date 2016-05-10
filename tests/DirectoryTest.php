<?php

namespace Lionar\FileSystem\Tests;

use 	Lionar\FileSystem\Directory,
	Lionar\Testing\TestCase,
	org\bovigo\vfs\vfsStream as VfsStream;

class DirectoryTest extends TestCase
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
	 * @expectedException InvalidArgumentException
	 * @dataProvider nonStringValues
	 */
	public function __construct_withNonStringValue_throwsInvalidArgumentException ( $value )
	{
		$directory = new Directory ( $value );
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 */
	public function __construct_withEmptyStringValue_throwsInvalidArgumentException ( )
	{
		$directory = new Directory ( '' );
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 */
	public function __construct_withNonExistingDirectory_throwsInvalidArgumentException ( )
	{
		$nonExistentDirectory = VfsStream::url ( 'root/nonExistentDirectory' );
		$directory = new Directory ( $nonExistentDirectory );
	}

	/**
	 * @test
	 * @dataProvider existentDirectories
	 */
	public function __construct_withExistentDirectory_setsPathOnDirectoryObject ( $existentDirectory )
	{
		$directory = new Directory ( $existentDirectory );
		assertThat( $directory->path, is ( identicalTo ( $existentDirectory ) ) );
	}

	public function existentDirectories ( )
	{
		return array ( 
		              array ( VfsStream::url ( 'root/Core' ) ),
		              array ( VfsStream::url ( 'root/Core/AbstractFactory' ) ),
		);
	}
}