<?php

namespace Lionar\FileSystem\Tests;

use Lionar\FileSystem\Directory,
	Lionar\Testing\TestCase,
	Mockery;

class DirectoryTest extends TestCase
{
	/*
	|--------------------------------------------------------------------------
	| Add
	|--------------------------------------------------------------------------
	*/
	/**
	 * @test
	 */
	public function add_withObject_addsObjectToDirectory ( )
	{
		$object = Mockery::mock ( 'Lionar\\FileSystem\\Object' )->shouldIgnoreMissing ( );
		$directory = new Directory ( 'application' );
		$directory->add ( $object );
		assertThat ( $directory->objects, hasItemInArray ( $object ) );
	}

	/**
	 * @test
	 */
	public function add_withObject_callsObjectMoveToMethod ( )
	{
		$directory = new Directory ( 'name' );
		$object = Mockery::mock ( 'Lionar\\FileSystem\\Object' );

		$object->shouldReceive ( 'moveTo' )->once ( );
		$directory->add ( $object );
	}

	/**
	 * @test
	 */
	public function add_withObjectThatAlreadyHasDirectoryAsParent_doesNotCallObjectMoveToMethod ( )
	{
		$directory = new Directory ( 'name' );
		$object = Mockery::mock ( 'Lionar\\FileSystem\\Object[]', array ( 'object name', $directory ) );
		$object->shouldNotReceive ( 'moveTo' );
		$directory->add ( $object );
	}

	/*
	|--------------------------------------------------------------------------
	| Has
	|--------------------------------------------------------------------------
	*/
	/**
	 * @test
	 */
	public function has_whenDirectoryDoesNotHaveObject_returnsFalse ( )
	{
		$object = Mockery::mock ( 'Lionar\\FileSystem\\Object', array ( 'name' ) );
		$directory = new Directory ( 'application' );
		assertThat( $directory->has ( $object ), is ( false ) );
	}

	/**
	 * @test
	 */
	public function has_whenDirectoryDoesHaveObject_returnsTrue ( )
	{
		$directory = new Directory ( 'application' );
		$object = Mockery::mock ( 'Lionar\\FileSystem\\Object[]', array ( 'name', $directory ) )->shouldIgnoreMissing ( );
		assertThat( $directory->has ( $object ), is ( true ) );
	}

	/*
	|--------------------------------------------------------------------------
	| Remove
	|--------------------------------------------------------------------------
	*/

	/**
	 * @test
	 */
	public function remove_withObjectThatExistsInDirectory_removesObjectFromDirectory ( )
	{
		$directory = new Directory ( 'application' );
		$object = Mockery::mock ( 'Lionar\\FileSystem\\Object[]', array ( 'name', $directory ) );
		$directory->remove ( $object );
		assertThat ( $directory->objects, noneOf ( contains ( $object ) ) );
	}

	/**
	 * @test
	 */
	public function remove_withObjectThatExistsInDirectory_callsObjectRemoveFromMethod ( )
	{
		$directory = new Directory ( 'application' );
		$object = Mockery::mock ( 'Lionar\\FileSystem\\Object' )->shouldIgnoreMissing ( );
		$object->shouldReceive ( 'removeFromParent' )->once ( );
		$directory->add ( $object );
		$directory->remove ( $object );
	}

	/*
	|--------------------------------------------------------------------------
	| Move to
	|--------------------------------------------------------------------------
	*/

	/**
	 * @test
	 */
	public function moveTo_withDirectoryForNewParent_alsoModifiesDirectoryObjectPath ( )
	{
		$newParent = new Directory ( 'root' );
		$application = new Directory ( 'application' );
		$object = Mockery::mock ( 'Lionar\\FileSystem\\Object[]', array ( 'object' ) );
		$application->add ( $object );
		$application->moveTo ( $newParent );
		assertThat ( $object->path, is ( identicalTo ( 'root/application/object' ) ) );
	}
}