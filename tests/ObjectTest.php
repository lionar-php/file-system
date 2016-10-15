<?php

namespace FileSystem\Tests;

use Mockery;
use Testing\TestCase;

class ObjectTest extends TestCase
{
	private $object, $parent, $newParent = null;

	public function setUp ( )
	{
		$root = Mockery::mock ( 'FileSystem\\Tests\\Assets\\Directory' );
		$root->name = 'root://';
		$root->isRoot = true;

		$parent = Mockery::mock ( 'FileSystem\\Tests\\Assets\\Directory' )->shouldIgnoreMissing ( );
		$parent->name = 'application';
		$parent->parent = $root;
		$parent->isRoot = false;

		$newParent = Mockery::mock ( 'FileSystem\\Tests\\Assets\\Directory' )->shouldIgnoreMissing ( );
		$newParent->name = 'themes';
		$newParent->parent = $root;
		$newParent->isRoot = false;

		$this->root = $root;
		$this->parent = $parent;
		$this->newParent = $newParent;
		$this->object = Mockery::mock ( 'FileSystem\\Object[]', array ( 'name', $parent ) );
	}

	/*
	|--------------------------------------------------------------------------
	| Constructor parent add calling.
	|--------------------------------------------------------------------------
	|
	| On construction the parent add method must be called.
	| We test if this is the case here.
	*/

	/**
	 * @test
	 */
	public function __construct_withDirectoryForParent_callsParentAddMethod ( )
	{
		$parent = Mockery::mock ( 'FileSystem\\Tests\\Assets\\Directory' );
		$parent->shouldReceive ( 'add' )->once ( );
		$parent->name = 'root://';
		$object = Mockery::mock ( 'FileSystem\\Object[]', array ( 'name', $parent ) );
	}

	/*
	|--------------------------------------------------------------------------
	| Constructor path testing.
	|--------------------------------------------------------------------------
	|
	| On construction we will need to set the path on our 
	| object. Here we test if that path is set correctly.
	*/

	/**
	 * @test
	 */
	public function __construct_withNameAndParentDirectory_setsPathOnObject ( )
	{
		assertThat ( $this->object->path, is ( identicalTo ( '/application/name' ) ) );
	}

	/*
	|--------------------------------------------------------------------------
	| Is directly in.
	|--------------------------------------------------------------------------
	|
	| This method checks if a given directory is the parent 
	| of that object. 
	*/

	/**
	 * @test
	 */
	public function isDirectlyInWithDirectoryThatIsNotTheObjectParent_returnsFalse ( )
	{
		$directory = Mockery::mock ( 'FileSystem\\Tests\\Assets\\Directory' );
		assertThat ( $this->object->isDirectlyIn ( $directory ), is ( identicalTo ( false ) ) );
	}

	/**
	 * @test
	 */
	public function isDirectlyInWithDirectoryThatIsTheObjectParent_returnsTrue ( )
	{
		assertThat ( $this->object->isDirectlyIn ( $this->parent ), is ( identicalTo ( true ) ) );
	}

	/*
	|--------------------------------------------------------------------------
	| Is directly in.
	|--------------------------------------------------------------------------
	|
	| This method checks if the object is inside the given 
	| directory. It does this check recursively till the root.
	*/

	/**
	 * @test
	 */
	public function isIn_withDirectoryThatObjectIsNotIn_returnsFalse ( )
	{
		$this->parent->shouldReceive ( 'isIn' )->andReturn ( false );
		assertThat ( $this->object->isIn ( $this->newParent ), is ( identicalTo ( false ) ) );
	}

	/**
	 * @test
	 */
	public function isIn_withDirectoryThatObjectIsIn_returnsTrue ( )
	{
		$directory = Mockery::mock ( 'FileSystem\\Tests\\Assets\\Directory' )->shouldIgnoreMissing ( );
		$directory->parent = $this->parent;
		$directory->shouldReceive ( 'isIn' )->andReturn ( true );

		$this->object->moveTo ( $directory );

		assertThat ( $this->object->isIn ( $this->parent ), is ( identicalTo ( true ) ) );
	}

	/**
	 * @test
	 */
	public function isIn_withRootDirectory_returnsTrue ( )
	{
		assertThat ( $this->object->isIn ( $this->root ), is ( identicalTo ( true ) ) );
	}

	/*
	|--------------------------------------------------------------------------
	| Move to.
	|--------------------------------------------------------------------------
	|
	| Move to allows this object to move to another directory.
	| Here we will test all the correct parent directory methods 
	| are called and that the object path is modified to the new
	| directory.
	*/

	/**
	 * @test
	 */
	public function moveTo_withDirectory_setsDirectoryAsParentOnObject ( )
	{
		$this->object->moveTo ( $this->newParent );
		assertThat ( $this->object->parent, is ( identicalTo ( $this->newParent ) ) );
	}

	/**
	 * @test
	 */
	public function moveTo_withDirectory_modifiesPath ( )
	{
		$this->object->moveTo ( $this->newParent );
		assertThat ( $this->object->path, is ( identicalTo ( '/themes/name' ) ) );
	}

	/**
	 * @test
	 */
	public function moveTo_withDirectory_callsOldParentRemoveMethod ( )
	{
		$this->parent->shouldReceive ( 'remove' )->with ( $this->object )->once ( );
		$this->object->moveTo ( $this->newParent );
	}

	/**
	 * @test
	 */
	public function moveTo_withDirectory_callsNewParentAddMethod ( )
	{
		$this->newParent->shouldReceive ( 'add' )->with ( $this->object )->once ( );
		$this->object->moveTo ( $this->newParent );
	}

	/*
	|--------------------------------------------------------------------------
	| Rename to.
	|--------------------------------------------------------------------------
	|
	| Rename to allows for renaming file system objects. 
	| Here we test if the new name is set correctly. Also
	| we check that the old name of the object is stored
	| temporarily.
	*/

	/**
	 * @test
	 */
	public function renameTo_withStringForName_setsNameOnObject ( )
	{
		$name = 'hello.php';
		$this->object->renameTo ( $name );
		assertThat ( $this->object->name, is ( identicalTo ( $name ) ) );
	}

	/**
	 * @test
	 */
	public function renameTo_withStringForName_setsFormerNameAsOldNamenObject ( )
	{
		$oldName = $this->object->name;
		$this->object->renameTo ( 'new name' );
		assertThat ( $this->object->oldName, is ( identicalTo ( $oldName ) ) );
	}
}