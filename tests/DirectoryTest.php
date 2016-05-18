<?php

namespace Lionar\FileSystem\Tests;

use 	Lionar\Testing\TestCase,
	Mockery,
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
		$directory = Mockery::mock ( 'Lionar\\FileSystem\\Directory', array ( $value ) );
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 */
	public function __construct_withEmptyStringValue_throwsInvalidArgumentException ( )
	{
		$directory = Mockery::mock ( 'Lionar\\FileSystem\\Directory', array ( '' ) );
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 */
	public function __construct_withNonExistingDirectory_throwsInvalidArgumentException ( )
	{
		$nonExistentDirectory = VfsStream::url ( 'root/nonExistentDirectory' );
		$directory = Mockery::mock ( 'Lionar\\FileSystem\\Directory', array ( $nonExistentDirectory ) );
	}

	/**
	 * @test
	 * @dataProvider existentDirectories
	 */
	public function __construct_withExistentDirectory_setsPathOnDirectoryObject ( $existentDirectory )
	{
		$directory = Mockery::mock ( 'Lionar\\FileSystem\\Directory', array ( $existentDirectory ) );
		assertThat( $directory->path, is ( identicalTo ( $existentDirectory ) ) );
	}

	/*
	|--------------------------------------------------------------------------
	| Data providers
	|--------------------------------------------------------------------------
	*/

	public function existentDirectories ( )
	{
		return array ( 
		              array ( VfsStream::url ( 'root/Core' ) ),
		              array ( VfsStream::url ( 'root/Core/AbstractFactory' ) ),
		);
	}
}