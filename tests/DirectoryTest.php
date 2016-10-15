<?php

namespace FileSystem;

use Mockery;
use Testing\TestCase;

class DirectoryTest extends TestCase
{
	private $directory, $root = null;

	public function setUp ( )
	{
		$root = Mockery::mock ( 'FileSystem\\Tests\\Assets\\Directory' )->shouldIgnoreMissing ( );
		$root->name = 'root://';

		$this->root = $root;
		$this->directory = new Directory ( 'application', $root );
	}

	/*
	|--------------------------------------------------------------------------
	| Add.
	|--------------------------------------------------------------------------
	|
	| Add allows to add an object to the directory. Here we test
	| that the object is added to the directory and that the correct
	| object methods are called.
	*/

	/**
	 * @test
	 */
	public function add_withObject_addsObjectToDirectoryObjects ( )
	{
		$object = Mockery::mock ( 'FileSystem\\Tests\\Assets\\Object' )->shouldIgnoreMissing ( );
		$object->name = $name = 'name';
		$this->directory->add ( $object );
		assertThat ( $this->directory->objects, hasKeyValuePair ( $name, $object ) );
	}

	/**
	 * @test
	 */
	public function add_withObjectWhenDirectoryIsNotObjectsParent_callsObjectMoveToMethod ( )
	{
		$object = Mockery::mock ( 'FileSystem\\Object' );
		$object->shouldReceive ( 'isDirectlyIn' )->andReturn ( false );
		$object->shouldReceive ( 'moveTo' )->with ( $this->directory )->once ( );
		$this->directory->add ( $object );
	}

	/**
	 * @test
	 */
	public function add_withObjectWhenDirectoryIsObjectsParent_doesNotcallObjectMoveToMethod ( )
	{
		$object = Mockery::mock ( 'FileSystem\\Object' );
		$object->shouldReceive ( 'isDirectlyIn' )->andReturn ( true );
		$object->shouldNotReceive ( 'moveTo' )->with ( $this->directory );
		$this->directory->add ( $object );
	}

	/*
	|--------------------------------------------------------------------------
	| Remove.
	|--------------------------------------------------------------------------
	|
	| Testing that objects are removed from the directory
	| objects array and that that correct object methods 
	| are called.
	*/

	/**
	 * @test
	 * @expectedException FileSystem\Exceptions\ObjectNotFoundException
	 */
	public function remove_withObjectThatIsNotInDirectory_throwsException ( )
	{
		$object = Mockery::mock ( 'FileSystem\\Object' )->shouldIgnoreMissing ( );
		$this->directory->remove ( $object );
	}

	/**
	 * @test
	 */
	public function remove_withObject_removesObjectFromDirectory ( )
	{
		$object = Mockery::mock ( 'FileSystem\\Tests\\Assets\\Object' )->shouldIgnoreMissing ( );
		$object->name = 'object';

		$this->directory->add ( $object );
		$this->directory->remove ( $object );

		assertThat ( $this->directory->objects, noneOf ( hasKey ( $object->name ), hasItem ( $object ) ) );
	}

	/*
	|--------------------------------------------------------------------------
	| Move to.
	|--------------------------------------------------------------------------
	|
	| Testing that move to also moves all the objects inside the directory.
	*/

	/**
	 * @test
	 */
	public function moveTo_withDirectoryForNewParent_callsObjectMoveToMethod ( )
	{
		$newParent = new Directory ( 'subdir', $this->root );
		$application = $this->directory;

		$object = Mockery::mock ( 'FileSystem\\Object' )->shouldIgnoreMissing ( );
		$application->add ( $object );
		$object->shouldReceive ( 'moveTo' )->with ( $application )->once ( );

		$application->moveTo ( $newParent );
	}
}