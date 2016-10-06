<?php

namespace FileSystem\Rules\Tests;

use FileSystem\Rules\Rule;
use Mockery;
use Testing\TestCase;

class RuleTest extends TestCase
{
	private $rule, $directory = null;

	public function setUp ( )
	{
		$this->directory = Mockery::mock ( 'FileSystem\\Directory' );
		$rule = new Rule ( 'name', 'description', 'objects',  $this->directory );
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 * @dataProvider  nonStringValues
	 */
	public function __construct_withNonStringValueForName_throwsException ( $value )
	{
		$rule = new Rule ( $value, 'description', 'objects', $this->directory );
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 */
	public function __construct_withEmptyStringValueForName_throwsException ( )
	{
		$rule = new Rule ( '', 'description', 'objects', $this->directory );
	}

	/**
	 * @test
	 */
	public function __construct_withStringValueForName_setsNameOnRule ( )
	{
		$name = 'local objects only';
		$rule = new Rule ( $name, 'description', 'objects', $this->directory );
		assertThat ( $rule->name, is ( identicalTo ( $name ) ) );
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 * @dataProvider  nonStringValues
	 */
	public function __construct_withNonStringValueForDescription_throwsException ( $value )
	{
		$rule = new Rule ( 'name', $value, 'objects', $this->directory );
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 */
	public function __construct_withEmptyStringValueForDescription_throwsException ( )
	{
		$rule = new Rule ( 'name', '', 'objects', $this->directory );
	}

	/**
	 * @test
	 */
	public function __construct_withStringValueForDescription_setsDescriptionOnRule ( )
	{
		$description = 'Only allow objects to be created on the local disk.';
		$rule = new Rule ( 'name', $description, 'objects', $this->directory );
		assertThat ( $rule->description, is ( identicalTo ( $description ) ) );
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 */
	public function __construct_withValueForObjectTypeThatIsNotAccepted_throwsException ( )
	{
		$rule = new Rule ( 'name', 'description', 'not accepted value', $this->directory );
	}

	/**
	 * @test
	 * @dataProvider acceptedTypes
	 */
	public function __construct_withValueForObjectTypeThatIsAccepted_setsObjectTypeOnRule ( $type )
	{
		$rule = new Rule ( 'name', 'description', $type, $this->directory );
		assertThat ( $rule->type, is ( identicalTo ( $type ) ) );
	}

	/**
	 * @test
	 */
	public function __construct_withDirectoryForDirectory_setsDirectoryOnRule ( )
	{
		$rule = new Rule ( 'name', 'description', 'objects', $this->directory );
		assertThat ( $rule->directory, is ( identicalTo ( $this->directory ) ) );
	}

	/*
	|--------------------------------------------------------------------------
	| Allowing disks.
	|--------------------------------------------------------------------------
	*/

	/**
	 * @test
	 */
	public function allow_withDisk_addsDiskToAllowedWithinRule ( )
	{

	}

	// next test restricting to disks.
	
	/*
	|--------------------------------------------------------------------------
	| Data providers.
	|--------------------------------------------------------------------------
	*/

	public function acceptedTypes ( )
	{
		return array (

			array ( 'objects' ),
			array ( 'directories' ),
			array ( 'files' )
		);
	}
}