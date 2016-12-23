<?php

namespace FileSystem\Drivers\Tests;

use FileSystem\Drive;
use FileSystem\Drivers\Manager;
use Mockery;
use Testing\TestCase;

class ManagerTest extends TestCase
{
	private $manager, $drive = null;

	public function setUp ( )
	{
		$this->manager = new Manager;
		$this->drive = Mockery::mock ( Drive::class );
		$this->manager->add ( 'local', $this->drive );
	}

	/**
	 * @test
	 */
	public function add_withNameAndDriver_addsDriverUnderNameInMapping ( )
	{
		$name = 'local development';
		
		$this->manager->add ( $name, $this->drive );
		assertThat ( $this->property ( $this->manager, 'mapping' ), hasEntry ( $name, $this->drive ) );
	}

	/*
	|--------------------------------------------------------------------------
	| Getting drives from the drives manager.
	|--------------------------------------------------------------------------
	|
	| Here we test an exception is thrown when we try to retrieve a drive that does
	| not exist. We also test the manager gives back the correct drive.
	*/

	/**
	 * @test
	 * @expectedException FileSystem\Exceptions\DriveNotFoundException
	 * @expectedExceptionMessage A driver with the name: inexistent could not be found.
	 */
	public function get_withNameThatDoesNotExist_throwsException ( )
	{
		$this->manager->get ( 'inexistent' );
	}

	/**
	 * @test
	 */
	public function get_withNameThatDoesExist_returnsDriveCoupledToThatName ( )
	{
		$drive = $this->manager->get ( 'local' );
		assertThat ( $drive, is ( identicalTo ( $this->drive ) ) );
	}
}