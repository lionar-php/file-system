<?php

namespace FileSystem\Tools;

use FileSystem\Directory;
use FileSystem\File;
use FileSystem\Root;

class ObjectFactory
{
	public function create ( $name, Directory $parent = null )
	{
		if ( empty ( $parent ) )
			return new Root ( $name );
		if ( empty ( pathinfo ( $name, PATHINFO_EXTENSION ) ) )
			return new Directory ( $name, $parent );
		return new File ( $name, $parent );
	}
}