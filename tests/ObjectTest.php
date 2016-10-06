<?php

namespace FileSystem;

use Testing\TestCase;
use	Mockery;

class ObjectTest extends TestCase
{
	private $object, $parent, $grandParent, $randomDirectory = null;

	public function setUp ( )
	{
		$this->grandParent = Mockery::mock ( 'FileSystem\\Directory' )->shouldIgnoreMissing ( );
		$this->parent = Mockery::mock ( 'FileSystem\\Directory', array ( 'parent', $this->grandParent ) )->shouldIgnoreMissing ( );
		$this->randomDirectory = Mockery::mock ( 'FileSystem\\Directory' );
		$this->object = Mockery::mock ( 'FileSystem\\Object[]', array ( 'name', $this->parent ) );
	}

	/*
	|--------------------------------------------------------------------------
	| Constructor.
	|--------------------------------------------------------------------------
	*/

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 * @dataProvider nonStringValues
	 */
	public function __construct_withNonStringValueForName_throwsException ( $value )
	{
		Mockery::mock ( 'FileSystem\\Object', array ( $value ) );
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException	
	 */
	public function __construct_withEmptyStringForName_throwsException ( )
	{
		Mockery::mock ( 'FileSystem\\Object', array ( '' ) );
	}

	/**
	 * @test
	 * @dataProvider objectNames
	 */
	public function __construct_withStringForName_setsNameOnObject ( $name )
	{
		$object = Mockery::mock ( 'FileSystem\\Object', array ( $name ) );
		assertThat ( $object->name, is ( identicalTo ( $name ) ) );
	}

	/**
	 * @test
	 */
	public function __construct_withDirectoryForParent_setsDirectoryAsParent ( )
	{
		$parent = Mockery::mock ( 'FileSystem\\Directory', array ( 'directory' ) );
		$parent->shouldReceive ( 'add' );
		$object = Mockery::mock ( 'FileSystem\\Object', array ( 'mock name', $parent ) );
		assertThat ( $object->parent, is ( identicalTo ( $parent ) ) );
	}

	/**
	 * @test
	 */
	public function __construct_withDirectoryForParent_addsItselfToTheParent ( )
	{
		$parent = Mockery::mock ( 'FileSystem\\Directory', array ( 'directory' ) )->shouldIgnoreMissing ( );
		$parent->shouldReceive ( 'add' )->once ( )->with ( 
			Mockery::mock ( 'FileSystem\\Object', array ( 'mock name', $parent ) )
		);
	}

	/**
	 * @test
	 * @dataProvider structures
	 */
	public function __construct_whenStructureIsSetOut_setsPathOnObject ( $object, $expectedPath )
	{
		assertThat ( $object->path, is ( identicalTo ( $expectedPath ) ) );
	}

	/*
	|--------------------------------------------------------------------------
	| Remove from parent.
	|--------------------------------------------------------------------------
	*/

	/**
	 * @test
	 */
	public function removeFromParent_whenParentIsset_removesParentFromObject ( )
	{
		$parent = Mockery::mock ( 'FileSystem\\Directory' )->shouldIgnoreMissing ( );
		$object = Mockery::mock ( 'FileSystem\\Object[]', array ( 'name', $parent ) );
		$object->removeFromParent ( );
		assertThat ( $object->parent, is ( identicalTo ( null ) ) );
	}

	/**
	 * @test
	 */
	public function removeFromParent_whenParentIsset_callsParentRemoveMethod ( )
	{
		$parent = Mockery::mock ( 'FileSystem\\Directory' )->shouldIgnoreMissing ( );
		$object = Mockery::mock ( 'FileSystem\\Object[]', array ( 'name', $parent ) );
		$parent->shouldReceive ( 'remove' )->once ( )->with ( $object );
		
		$object->removeFromParent ( );
	}

	/**
	 * @test
	 */
	public function removeFromParent_whenParentIsset_modifiesObjectPath ( )
	{
		$name = 'name';
		$parent = Mockery::mock ( 'FileSystem\\Directory' )->shouldIgnoreMissing ( );
		$object = Mockery::mock ( 'FileSystem\\Object[]', array ( $name, $parent ) );
		$parent->shouldReceive ( 'remove' )->once ( )->with ( $object );
		
		$object->removeFromParent ( );
		assertThat ( $object->path, is ( identicalTo ( $name ) ) );
	}

	/*
	|--------------------------------------------------------------------------
	| Move to.
	|--------------------------------------------------------------------------
	*/

	/**
	 * @test
	 */
	public function moveTo_whenObjectHasCurrentlyGotAParent_callsCurrentParentRemoveMethod ( )
	{
		$currentParent = Mockery::mock ( 'FileSystem\\Directory', array ( 'directory' ) )->shouldIgnoreMissing ( );
		
		$object = Mockery::mock ( 'FileSystem\\Object[]', array ( 'object', $currentParent ) );
		$currentParent->shouldReceive ( 'remove' )->once ( )->with ( $object );
		
		$directory = Mockery::mock ( 'FileSystem\\Directory', array ( 'directory' ) )->shouldIgnoreMissing ( );
		$object->moveTo ( $directory );
	}

	/**
	 * @test
	 */
	public function moveTo_whenObjectHasNoCurrentParent_doesNotCallCurrentParentRemoveMethod ( )
	{		
		$object = Mockery::mock ( 'FileSystem\\Object[]', array ( 'object' ) );
		
		$directory = Mockery::mock ( 'FileSystem\\Directory', array ( 'directory' ) )->shouldIgnoreMissing ( );
		$object->moveTo ( $directory );
	}

	/**
	 * @test
	 */
	public function moveTo_withDirectory_setsDirectoryAsParent ( )
	{
		$directory = Mockery::mock ( 'FileSystem\\Directory', array ( 'directory' ) )->shouldIgnoreMissing ( );
		$object = Mockery::mock ( 'FileSystem\\Object[]', array ( 'object' ) );
		$object->moveTo ( $directory );
		assertThat ( $object->parent, is ( identicalTo ( $directory ) ) );
	}

	/**
	 * @test
	 */
	public function moveTo_withDirectoryWhenFileDoesNotExistInDirectory_callsDirectoryAddMethod ( )
	{
		$object = Mockery::mock ( 'FileSystem\\Object[]', array ( 'object' ) );
		$directory = Mockery::mock ( 'FileSystem\\Directory', array ( 'directory' ) );
		$directory->shouldReceive ( 'has' )->once ( )->andReturn ( false );
		$directory->shouldReceive ( 'add' )->once ( )->with ( $object );
		$object->moveTo ( $directory );
	}

	/**
	 * @test
	 */
	public function moveTo_withDirectoryWhenFileDoesNotExistInDirectory_ModifiesObjectPath ( )
	{
		$object = Mockery::mock ( 'FileSystem\\Object[]', array ( 'object' ) );
		$directory = Mockery::mock ( 'FileSystem\\Directory', array ( 'directory' ) );
		$directory->shouldReceive ( 'has' )->once ( )->andReturn ( false );
		$directory->shouldReceive ( 'add' )->once ( )->with ( $object );
		$object->moveTo ( $directory );
		assertThat ( $object->path, is ( identicalTo ( 'directory/object' ) ) );
	}

	/**
	 * @test
	 */
	public function moveTo_withDirectoryWhenFileDoesAlreadyExistInDirectory_doesNotcallDirectoryAddMethod ( )
	{
		$directory = Mockery::mock ( 'FileSystem\\Directory', array ( 'directory' ) )->shouldIgnoreMissing ( );
		$directory->shouldReceive ( 'has' )->once ( )->andReturn ( true );
		$object = Mockery::mock ( 'FileSystem\\Object[]', array ( 'object', $directory ) );
		$directory->shouldNotReceive ( 'add' );
		$object->moveTo ( $directory );
	}

	/*
	|--------------------------------------------------------------------------
	| Is directly in.
	|--------------------------------------------------------------------------
	*/

	/**
	 * @test
	 */
	public function isDirectlyIn_withDirectoryThatIsNotTheObjectParent_returnsFalse ( )
	{
		assertThat ( $this->object->isDirectlyIn ( $this->grandParent ), is ( identicalTo ( false ) ) );
	}

	/**
	 * @test
	 */
	public function isDirectlyIn_withDirectoryThatIsTheObjectParent_returnsTrue ( )
	{	
		assertThat ( $this->object->isDirectlyIn ( $this->parent ), is ( identicalTo ( true ) ) );
	}

	/*
	|--------------------------------------------------------------------------
	| Is in.
	|--------------------------------------------------------------------------
	*/

	/**
	 * @test
	 */
	public function isIn_withDirectoryThatObjectIsNotInside_returnsFalse ( )
	{
		assertThat ( $this->object->isIn ( $this->randomDirectory ), is ( identicalTo ( false ) ) );
	}

	/**
	 * @test
	 */
	public function isIn_withDirectoryThatObjectIsInside_returnsTrue ( )
	{
		assertThat ( $this->object->isIn ( $this->parent ), is ( identicalTo ( true ) ) );
	}

	/*
	|--------------------------------------------------------------------------
	| Data providers.
	|--------------------------------------------------------------------------
	*/

	public function objectNames ( )
	{
		return array (

			array ( 'application' ),
			array ( 'dashboard.php' )
		);
	}

	public function structures ( )
	{
		$root = Mockery::mock ( 'FileSystem\\Directory', array ( 'root' ) );
		$root->shouldReceive ( 'add' );
		$application = Mockery::mock ( 'FileSystem\\Directory', array ( 'application', $root ) );
		$application->shouldReceive ( 'add' );



		return array (

			array ( Mockery::mock ( 'FileSystem\\Object', array ( 'dashboard.php', $root ) ), 'root/dashboard.php' ),
			array ( Mockery::mock ( 'FileSystem\\Object', array ( 'filename.php', $application ) ), 'root/application/filename.php' ),
			array ( Mockery::mock ( 'FileSystem\\Object', array ( 'other-file.txt', $application ) ), 'root/application/other-file.txt' ),			
		);
	}  
}