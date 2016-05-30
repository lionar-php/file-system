<?php

namespace Lionar\FileSystem\Tests;

use Lionar\FileSystem\File,
	Lionar\Testing\TestCase;

class FileTest extends TestCase
{
	private $file = null;

	public function setUp ( )
	{
		$this->file = new File ( 'file-name.php' );
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