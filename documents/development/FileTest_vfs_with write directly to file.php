<?php

namespace Lionar\FileSystem\Tests;

use 	Lionar\FileSystem\File,
	Lionar\Testing\TestCase,
	org\bovigo\vfs\vfsStream as Vfs;

class FileTest extends TestCase
{
	private $file = null;
	private $path, $extension = '';

	public function setUp (  )
	{
		$this->root = Vfs::setup( 'root' );
        		Vfs::newFile( 'file.txt' )->at( $this->root )->setContent( 'The new contents of the file' );
		$this->path = 'directory/file.txt';
		$this->extension = 'txt';
		$this->file = new File ( $this->path );
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 * @dataProvider nonStringValues
	 */
	public function __construct_withNonStringValueForPath_throwsException ( $value )
	{
		$file = new File ( $value );
	}

	/**
	 * @test
	 */
	public function __construct_withValidPathValue_setsPathOnTheFile (  )
	{
		assertThat( $this->file->path, is ( identicalTo ( $this->path ) ) );
	}

	/**
	 * @test
	 */
	public function __construct_withValidPathValue_setsExtensionOnTheFile (  )
	{
		assertThat( $this->file->extension, is ( identicalTo ( $this->extension ) ) );
	}

	/**
	 * @test
	 */
	public function __construct_withContent_setsContentOntoFileObject (  )
	{
		$contents = 'my content';
		$file = new File ( 'directory/file', $contents );
		assertThat ( $file->contents, is ( identicalTo ( $contents ) ) );
	}

	/**
	 * @test
	 */
	public function __construct_withContent_serializesContentIntoFile (  )
	{
		$contents = 'my content';
		$file = new File ( Vfs::url ( 'root/file.txt' ), $contents );
		assertThat ( file_get_contents( $file ), is ( identicalTo ( serialize( $contents ) ) ) );
	}

	/**
	 * @test
	 */
	public function __toString_whenAValidPathHasBeenSet_returnsTheFilePath (  )
	{
		assertThat( $this->file->__toString( ), is ( identicalTo ( $this->path ) ) );
	}

	// /**
	//  * @test
	//  */
	// public function overwrite_withContent_serializesContentAndOverwritesFile ( )
	// {

	// }
}