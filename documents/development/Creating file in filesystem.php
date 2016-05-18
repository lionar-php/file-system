<?php

class LocalFile extends File
{
	public function __construct ( $path, $contents = array ( ) )
	{
		parent::__construct ( $path, $contents )
		if ( ! file_exists ( $path ) or ! is_file ( $path ) )
			file_put_contents ( $path, serialize( $this->contents ) )
	}
}