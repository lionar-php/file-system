<?php

class File
{
	public function __construct ( $name, Directory $parent )
	{
		$this->name = $name;
		$parent->add ( $this );
		$this->parent = $parent;
	}

	public function moveTo ( Directory $directory )
	{
		$this->parent = $directory;
		$this->setPath ( );

		if ( ! $this->isIn ( $directory ) )
			$directory->add ( $this );
	}

	public function isIn ( Directory $directory )
	{
		return in_array ( $this, $directory->files );
	}

}

$application = new Directory ( 'application' );
$file = new File ( 'my file.php', $application );
