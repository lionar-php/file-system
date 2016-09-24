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

	/*
	|--------------------------------------------------------------------------
	| Construct method testing.
	|--------------------------------------------------------------------------
	*/

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

	/*
	|--------------------------------------------------------------------------
	| To string method testing.
	|--------------------------------------------------------------------------
	*/

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
	| is empty method testing.
	|--------------------------------------------------------------------------
	*/

	/**
	 * @test
	 */
	public function isEmpty_whenFileContentEqualsEmptyString_returnsTrue ( )
	{
		$this->file->write ( '' );
		assertThat ( $this->file->isEmpty ( ), is ( identicalTo ( true ) ) );
	}

	/**
	 * @test
	 */
	public function isEmpty_whenFileContentEqualsNonEmptyString_returnsFalse ( )
	{
		$this->file->write ( 'string' );
		assertThat ( $this->file->isEmpty ( ), is ( identicalTo ( false ) ) );
	}

	/**
	 * @test
	 */
	public function isEmpty_whenFileContentEqualsEmptySerializedString_returnsTrue ( )
	{
		$this->file->write ( serialize ( '' ) );
		assertThat ( $this->file->isEmpty ( ), is ( identicalTo ( true ) ) );
	}

	/**
	 * @test
	 */
	public function isEmpty_whenFileContentEqualsNonEmptySerializedString_returnsTrue ( )
	{
		$this->file->write ( serialize ( 'some string' ) );
		assertThat ( $this->file->isEmpty ( ), is ( identicalTo ( false ) ) );
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