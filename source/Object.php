<?php

namespace FileSystem;

use Accessibility\Readable;
use FileSystem\Exceptions\InvalidObjectName;
use InvalidArgumentException;

abstract class Object
{
	use Readable;

	protected $name, $path, $oldName = '';
	protected $parent = null;

	public function __construct ( $name, Directory $parent )
	{
		$this->named ( $name );
		$this->parentedBy ( $parent );
		$this->setPath ( );
	}

	public function moveTo ( Directory $directory )
	{
		$this->parent->remove ( $this );
		$this->parent = $directory;
		$this->setPath ( );
		$directory->add ( $this );
	}

	public function isDirectlyIn ( Directory $directory ) : bool
	{
		return  ( bool ) ( $directory === $this->parent );
	}

	public function isIn ( Directory $directory ) : bool
	{
		if ( $directory instanceOf Root )
			return true;
		if ( $this->isDirectlyIn ( $directory ) )
			return true;
		if ( $this->hasLevelUp ( $this->parent ) )
			return $this->parent->isIn ( $directory );
		return false;
	}

	public function renameTo ( $name )
	{
		$this->oldName = $this->name;
		$this->named ( $name );
	}

	protected function setPath ( )
	{
		$this->path = $this->name;
		$this->itterateParents ( $this->parent );
		$this->path = '/' . $this->path;
	}

	private function itterateParents( Directory $directory )
	{
		if ( ! $this->hasLevelUp ( $directory ) )
			return;

		$this->prependDirectoryName ( $directory->name );
		return $this->itterateParents ( $directory->parent );
	}

	private function hasLevelUp ( Directory $directory )
	{
		return ( bool ) ! ( $directory instanceOf Root );
	}

	private function prependDirectoryName ( $name )
	{
		$this->path = $name . '/' . $this->path;
	}

	protected function named ( $name )
	{
		if ( ! is_string ( $name ) or empty ( $name ) )
			throw new InvalidArgumentException ( '$name must be a non empty string.' );
		if ( strpos ( $name, '/' ) !== false )
			throw new InvalidObjectName ( $name );
		$this->name = $name;
	}

	private function parentedBy ( Directory $parent )
	{
		$this->parent = $parent;
		$parent->add ( $this );
	}
}