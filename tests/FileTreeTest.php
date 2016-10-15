<?php

namespace FileSystem\Tests;

use FileSystem\FileTree;
use Testing\TestCase;
use Mockery;

class FileTreeTest extends TestCase
{
	private $fileTree, $root = null;

	public function setUp ( )
	{
		$this->root = Mockery::mock ( 'FileSystem\\Root' )->shouldIgnoreMissing ( );
		$this->fileTree = new FileTree ( array ( $this->root ) );
	}

	/**
	 * @test
	 */
	public function add_withObject_addsObjectToFileTreeObjectsUnderPathAsKey ( )
	{
		$parent = Mockery::mock ( 'FileSystem\\Directory', array ( 'application', $this->root ) )->shouldIgnoreMissing ( );
		$object = Mockery::mock ( 'FileSystem\\Object', array ( 'dashboard.php', $parent ) );

		$this->fileTree->add ( $object );
		assertThat ( $this->fileTree->objects, hasEntry ( '/application/dashboard.php', $object ) );
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
		$object = Mockery::mock ( 'FileSystem\\Object', array ( 'nonExistent', $this->root ) );
		$has = $this->fileTree->has ( $object );
		assertThat ( $has, is ( false ) );
	}
}