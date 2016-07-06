<?php

namespace Lionar\FileSystem\Tests;

use Lionar\Testing\TestCase,
	Mockery;

class FileSystemTest extends TestCase
{


	/**
	 * @test
	 * @dataProvider objects
	 */
	public function findFilesIn_withDirectory_returnsAllFilesIncludingNestedFilesFromDirectory ( array $objects, array $expectedFiles )
	{
		$directory = Mockery::mock ( 'Lionar\\FileSystem\\Directory' );
		$directory->objects = $objects;

		$fileSystem = Mockery::mock ( 'Lionar\\FileSystem\\FileSystem[]' );
		$files = $fileSystem->findFilesIn ( $directory );

		assertThat ( $files, is ( arrayContainingInAnyOrder ( $expectedFiles ) ) );
	}

	public function objects ( )
	{
		$file = Mockery::mock ( 'Lionar\\FileSystem\\File', array ( 'file.txt' ) );
		$directory = Mockery::mock ( 'Lionar\\FileSystem\\Directory', array ( 'application' ) )->shouldIgnoreMissing ( );
		$nestedFile = Mockery::mock ( 'Lionar\\FileSystem\\File', array ( 'nested.txt', $directory ) );
		$directory->objects = array ( $nestedFile );

		return array (

			array ( array ( $file, $directory ), array ( $file, $nestedFile ) )
		);
	}
}