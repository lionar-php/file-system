<?php

namespace FileSystem\Tests;

use FileSystem\File;
use	Testing\TestCase;

class FileTest extends TestCase
{
	private $file = null;

	public function setUp ( )
	{
		$this->file = new File ( 'file-name.php' );
	}

	/**
	 * @test
	 */
	public function __construct_withNameWithExtension_setsExtensionOnFile ( )
	{
		$file = new File ( 'dashboard.php' );
		assertThat ( $file->extension, is ( identicalTo ( 'php' ) ) );
	}

	/**
	 * @test
	 * @dataProvider contents
	 */
	public function __construct_withContent_setsContentOnFileObject ( $content )
	{
		$file = new File ( 'mock name', null, $content );
		assertThat ( $file->content, is ( identicalTo ( $content ) ) );
	}

	/**
	 * @test
	 */
	public function __toString_whenPathIsSet_returnsFilePath ( )
	{
		assertThat( ( string ) $this->file, is ( identicalTo ( 'file-name.php' ) ) );
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 * @dataProvider nonStringValues
	 */
	public function write_withNonStringValue_throwsException ( $value )
	{
		$this->file->write ( $value );
	}

	/**
	 * @test
	 * @dataProvider contents
	 */
	public function write_withString_setsStringasContentOnFile ( $content )
	{
		$this->file->write ( $content );
		assertThat ( $this->file->content, is ( identicalTo ( $content ) ) );
	}

	/*
	|--------------------------------------------------------------------------
	| Data providers
	|--------------------------------------------------------------------------
	*/

	public function contents ( )
	{
		return array (

			array ( 'helloo' ),
			array ( 'my content' ),
			array ( '' )
		);
	}
}