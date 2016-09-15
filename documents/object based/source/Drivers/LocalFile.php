<?php

class LocalFile extends File
{
	public function __construct ( $name, LocalDirectory $parent )
	{
		parent::__construct ( $name, $parent );
		$this->write ( '' );
	}

	public function write ( $content )
	{
		parent::write ( $content );
		file_put_contents ( $this->path, $this->content );
	}
}