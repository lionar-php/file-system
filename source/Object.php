<?php

namespace Lionar\FileSystem;

use InvalidArgumentException;

abstract class Object
{
	protected $name, $path = '';
	protected $parent = null;

	public function __construct ( $name, Directory $parent = null )
	{
		if ( ! is_string ( $name ) or empty ( $name ) )
			throw new InvalidArgumentException ( );
		$this->name = $name;

		$this->addParent ( $parent );
		$this->setFullPath ( );
	}

	public function __get ( $property )
	{
		if ( isset ( $this->{ $property } ) )
			return $this->{ $property };
	}

	public function moveTo ( Directory $directory )
	{
		// $this->actions [ 'move' ] [ $this->path ] = array ( $this, $this->parent )
		$this->removeFromParent ( );
		$this->parent = $directory;
		if ( ! $directory->has ( $this ) )
			$directory->add ( $this );
		$this->setFullPath ( );
	}

	public function removeFromParent ( )
	{
		if ( ! is_null ( $this->parent ) )
			$this->parent->remove ( $this );
		$this->parent = null;
		$this->setFullPath ( );
	}

	private function addParent ( Directory $parent = null )
	{
		if ( ! is_null ( $parent ) )
			$parent->add ( $this );
		$this->parent = $parent;
	}

	protected function setFullPath ( )
	{
		$this->path = $this->name;
		if ( $this->parent !== null )
			$this->itterateParents ( $this->parent );
	}

	private function hasLevelUp ( Directory $directory )
	{
		return ( isset ( $directory->parent ) and ! empty ( $directory->parent ) );
	}

	private function itterateParents( Directory $directory )
	{
			$this->prependDirectoryName ( $directory->name );
			if ( $this->hasLevelUp ( $directory ) )
				return $this->itterateParents ( $directory->parent );
	}

	private function prependDirectoryName ( $name )
	{
		$this->path = $name . '/' . $this->path;
	}
}