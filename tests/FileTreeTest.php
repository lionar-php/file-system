<?php

namespace Lionar\FileSystem\Tests;

use Lionar\FileSystem\FileTree,
	Lionar\Testing\TestCase,
	Mockery;

class FileTreeTest extends TestCase
{
	private $fileTree, $root = null;

	public function setUp ( )
	{
		$this->root = Mockery::mock ( 'Lionar\\FileSystem\\Object', array ( 'root' ) );
		$this->fileTree = new FileTree ( array ( $this->root ) );
	}

	/**
	 * @test
	 * @dataProvider initialFileTrees
	 */
	public function __construct_withArrayForFileObjects_setsInitalFileObjectsOnFileTree ( $objects, $expected )
	{
		$fileTree = new FileTree ( $objects );
		assertThat ( $fileTree->objects, is ( identicalTo ( $expected ) ) );
	}

	/**
	 * @test
	 */
	public function add_withObject_addsObjectToFileTreeObjectsUnderPathAsKey ( )
	{
		$parent = Mockery::mock ( 'Lionar\\FileSystem\\Directory', array ( 'application' ) )->shouldIgnoreMissing ( );
		$object = Mockery::mock ( 'Lionar\\FileSystem\\Object', array ( 'dashboard.php', $parent ) );

		$this->fileTree->add ( $object );
		assertThat ( $this->fileTree->objects, hasEntry ( 'application/dashboard.php', $object ) );
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 */
	public function add_withObjectPathThatAlreadyExists_throwsException ( )
	{
		$this->fileTree->add ( $this->root );
	}

	/**
	 * @test
	 */
	public function has_withObjectPathThatAlreadyExists_returnsTrue ( )
	{
		$has = $this->fileTree->has ( $this->root );
		assertThat ( $has, is ( true ) );
	}

	/**
	 * @test
	 */
	public function has_withObjectPathThatDoesNotExists_returnsFalse ( )
	{
		$object = Mockery::mock ( 'Lionar\\FileSystem\\Object', array ( 'nonExistent' ) );
		$has = $this->fileTree->has ( $object );
		assertThat ( $has, is ( false ) );
	}


	/*
	|--------------------------------------------------------------------------
	| Data providers
	|--------------------------------------------------------------------------
	*/

	public function initialFileTrees ( )
	{
		$object = Mockery::mock ( 'Lionar\\FileSystem\\Object', array ( 'object' ) );
		$directory = Mockery::mock ( 'Lionar\\FileSystem\\Directory', array ( 'directory' ) );
		$file = Mockery::mock ( 'Lionar\\FileSystem\\File[]', array ( 'file' ) );

		return array (
			array ( array ( ), array ( ) ),
			array ( array ( $object ), array ( 'object' => $object ) ),
			array ( array ( $directory, $file ), array ( 'directory' => $directory, 'file' => $file ) ),
		);
	}
}