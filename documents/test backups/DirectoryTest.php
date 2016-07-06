<?php

	/*
	|--------------------------------------------------------------------------
	| Getting all the files out of the directory
	|--------------------------------------------------------------------------
	*/

	/**
	 * @test
	 */
	public function files_withFilesSetInDirectory_returnsAllFilesIncludingNestedFiles ( )
	{
		$directory = new Directory ( 'application' );
		$file = Mockery::mock ( 'Lionar\\FileSystem\\File[]', array ( 'file.txt', $directory ) );
		assertThat ( $directory->files ( ), hasItemInArray ( $file ) );
	}