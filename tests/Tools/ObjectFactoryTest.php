<?php

namespace FileSystem\Tools\Tests;

use FileSystem\Directory;
use FileSystem\File;
use FileSystem\Root;
use FileSystem\Tools\ObjectFactory;
use Mockery;
use Testing\TestCase;

class ObjectFactoryTest extends TestCase
{
	private $factory, $parent = null;

	public function setUp ( )
	{
		$this->parent = Mockery::mock ( Root::class )->shouldIgnoreMissing ( );
		$this->factory = new ObjectFactory;
	}

	/*
	|--------------------------------------------------------------------------
	| Creating directory objects.
	|--------------------------------------------------------------------------
	|
	| Here we test if a root, directory or file is created
	| correctly.
	*/

	/**
	 * @test
	 */
	public function create_withStringWithoutExtensionAndNoParent_returnsANewRoot ( )
	{
		$root = 'root';

		$rootObject = $this->factory->create ( $root );
		assertThat ( $rootObject->name, is ( identicalTo ( $root ) ) );
		assertThat ( $rootObject, is ( anInstanceOf ( Root::class ) ) );
	}

	/**
	 * @test
	 */
	public function create_withStringWithoutExtension_returnsANewDirectory ( )
	{
		$directory = 'application';
		
		$directoryObject = $this->factory->create ( $directory, $this->parent );
		assertThat ( $directoryObject->name, is ( identicalTo ( $directory ) ) );
		assertThat ( $directoryObject, is ( anInstanceOf ( Directory::class ) ) );
		assertThat ( $directoryObject->parent, is ( identicalTo ( $this->parent ) ) );
	}

	/**
	 * @test
	 */
	public function create_withStringWithExtension_returnsANewFile ( )
	{
		$file = 'file.php';

		$fileObject = $this->factory->create ( $file, $this->parent );
		assertThat ( $fileObject->name, is ( identicalTo ( $file ) ) );
		assertThat ( $fileObject, is ( anInstanceOf ( File::class ) ) );
		assertThat ( $fileObject->parent, is ( identicalTo ( $this->parent ) ) );
	}

	/*
	|--------------------------------------------------------------------------
	| Create from array.
	|--------------------------------------------------------------------------
	|
	| Create a tree of file system objects from an array of
	| strings, returned as an array. 
	*/
}