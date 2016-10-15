<?php

namespace FileSystem;

class Manager
{
	private $disks = null;

	public function __construct ( Disks\Manager $disks )
	{
		$this->disks = $disks;
	}

	public function write ( File $file )
	{
		foreach ( $this->disks as $disk )
			$disk->write ( $file );
	}

	public function make ( Directory $directory )
	{
		foreach ( $this->disks as $disk )
			$disk->make ( $directory );
	}
}