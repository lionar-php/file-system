<?php

namespace FileSystem;

class Root extends Directory
{
	protected $name = '';
	protected $parent = null;

	public function __construct ( $name )
	{
		$this->name = $name;
	}
}