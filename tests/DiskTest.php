<?php

namespace FileSystem\Tests;

use FileSystem\Disk;
use Mockery;
use Testing\TestCase;

class DiskTest extends TestCase
{
	private $disk, $driver = null;
	private $location = '';

	public function setUp ( )
	{
		$this->driver = Mockery::mock ( 'FileSystem\\Driver' );
		$this->disk = new Disk ( 'name', $this->location = '/local/location', $this->driver );
	}

	/*
	|--------------------------------------------------------------------------
	| Constructor.
	|--------------------------------------------------------------------------
	*/

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 * @dataProvider  nonStringValues
	 */
	public function __construct_withNonStringValueForName_throwsException ( $value )
	{
		$disk = new Disk ( $value, '', $this->driver );
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 */
	public function __construct_withEmptyStringForName_throwsException ( )
	{
		$disk = new Disk ( '', '', $this->driver );
	}

	/**
	 * @test
	 */
	public function __construct_withStringForName_setsNameOnDisk ( )
	{
		$name = 'local';
		$disk = new Disk ( $name, '', $this->driver );
		assertThat ( $disk->name, is ( identicalTo ( $name ) ) );
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 * @dataProvider  nonStringValues
	 */
	public function __construct_withNonStringValueForLocation_throwsException ( $value )
	{
		$disk = new Disk ( 'name', $value, $this->driver );
	}

	/**
	 * @test
	 */
	public function __construct_withStringForLocation_setsLocationOnDisk ( )
	{
		$location = '/local/location';
		$disk = new Disk ( 'name', $location, $this->driver );
		assertThat ( $disk->location, is ( identicalTo ( $location ) ) );
	}

	/*
	|--------------------------------------------------------------------------
	| Make.
	|--------------------------------------------------------------------------
	*/

	/**
	 * @test
	 */
	public function make_withDirectory_callsDriverMakeMethod ( )
	{
		$directory = Mockery::mock ( 'FileSystem\\Directory' );
		$this->driver->shouldReceive ( 'make' )->with ( $directory, $this->location )->once ( );
		$this->disk->make ( $directory );
	}

	/*
	|--------------------------------------------------------------------------
	| Write.
	|--------------------------------------------------------------------------
	*/

	/**
	 * @test
	 */
	public function write_withFile_callsDriverMakeMethod ( )
	{
		$file = Mockery::mock ( 'FileSystem\\File' );
		$this->driver->shouldReceive ( 'write' )->with ( $file, $this->location )->once ( );
		$this->disk->write ( $file );
	}
}