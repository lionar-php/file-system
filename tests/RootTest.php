<?php

namespace FileSystem\Tests;

use FileSystem\Root;
use Testing\TestCase;

class RootTest extends TestCase
{
	/**
	 * @test
	 */
	public function __construct_withName_setsNameOnRoot ( )
	{
		$name = '/';
		$root = new Root ( $name );
		assertThat ( $root->name, is ( identicalTo ( $name ) ) );
	}
}