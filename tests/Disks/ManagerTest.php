<?php

namespace FileSystem\Disks\Tests;

use FileSystem\Disks\Manager;
use Mockery;
use Testing\TestCase;

class ManagerTest extends TestCase
{
	private $manager, $existentDisk = null;

	public function setUp ( )
	{
		$this->existentDisk = Mockery::mock ( 'FileSystem\\Disk' );
		$this->existentDisk->name = 'some disk';
		$this->manager = new Manager;
		$this->manager->add ( $this->existentDisk );
	}

	/*
	|--------------------------------------------------------------------------
	| Add.
	|--------------------------------------------------------------------------
	*/

	/**
	 * @test
	 * @expectedException FileSystem\Exceptions\DiskAlreadyExistsException
	 */
	public function add_withDiskThatIsAlreadySetOnTheManager_throwsException ( )
	{
		$this->manager->add ( $this->existentDisk );
	}

	/**
	 * @test
	 */
	public function add_withDiskThatDoesNotExistInManager_setsDiskOnManager ( )
	{
		$disk = Mockery::mock ( 'FileSystem\\Disk' );
		$disk->name = $name = 'local';

		$this->manager->add ( $disk );
		assertThat ( $this->property ( $this->manager, 'disks' ), hasEntry ( $name, $disk ) );
	}

	/*
	|--------------------------------------------------------------------------
	| Get.
	|--------------------------------------------------------------------------
	*/

	/**
	 * @test
	 * @expectedException FileSystem\Exceptions\DiskNotFoundException
	 */
	public function get_withDiskThatDoesNotExistOnManager_throwsException ( )
	{
		$this->manager->get ( 'inexistent disk' );
	}

	/**
	 * @test
	 */
	public function get_withDiskThatDoesExistOnManager_returnsDisk ( )
	{
		$disk = $this->manager->get ( $this->existentDisk->name );
		assertThat ( $disk, is ( identicalTo ( $this->existentDisk ) ) );
	}
}