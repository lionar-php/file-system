<?php

namespace FileSystem\Tests\Assets;

class Directory extends \FileSystem\Directory
{
	public $name = '';
	public $parent = null;
	public $isRoot = false;
	public $objects = array ( );
}