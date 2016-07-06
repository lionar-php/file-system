<?php

use Lionar\FileSystem\Directory;
use Lionar\FileSystem\Object;
use Lionar\FileSystem\File;

require __DIR__ . '/../vendor/autoload.php';

$oldmask = umask(0);


$root = new Directory ( 'lionar', null );
$application = new Directory ( 'application', $root );
$storage = new Directory ( 'storage', $root );
$sports = new Directory ( 'sports', $application );
$dashboard = new File ( 'dashboard.php', $application );
$missing = new File ( 'missing.php', $application );

class FileSystem
{
	private $fileTree = null;

	public function __construct ( FileTree $fileTree )
	{
		$this->fileTree = $fileTree;
	}

	public function create ( Directory $directory )
	{
		$this->fileTree->add ( $directory );
		if ( ! file_exists ( $directory->path ) or ! is_dir ( $directory->path ) )
			mkdir ( $directory->path );
	}

	public function write ( $content, File $to )
	{
		// do some permission solving also
		$this->fileTree->add ( $to );
		$to->write ( $content );
		file_put_contents ( $to->path, $to->content );
	}

	public function move ( Object $from, Directory $to )
	{
		if ( ! $this->fileTree->has ( $from ) or ! $this->fileTree->has ( $to ) )
			return false;
		
		rename ( $from->path, $to->path . '/' . $from->name );
		$this->fileTree->move ( $from, $to );
	}

	public function __get ( $property )
	{
		if ( isset ( $this-> { $property } ) )
			return $this-> { $property };
	}
}

// the file tree's resposibility is to keep the object graph in sync with
// the actual file system. 
class FileTree
{
	public $objects = array ( );
	private $file = '';

	public function __construct ( $file )
	{
		if ( filesize ( $file ) === 0  )
			file_put_contents ( $file, serialize( $this->objects ) );
		$this->objects = unserialize ( file_get_contents ( $file ) );
		$this->file = $file;
	}

	public function add ( Object $object )
	{
		if ( ! $this->has ( $object ) )
			$this->objects [ $object->path ] = $object;			
	}

	public function has ( Object $object )
	{
		return isset ( $this->objects [ $object->path ] );
	}

	public function move ( Object $from, Directory $to )
	{
		$from = $this->objects [ $from->path ];
		$to = $this->objects [ $to->path ];
		unset ( $this->objects [ $from->path ] );
		$from->moveTo ( $to );
		$this->objects [ $to->path . '/' . $from->name ] = $from;

		// foreach ( $this->objects as $object )
		// 	if ( $object->parent === $from )
		// 		var_dump('yeah');

		// also change the paths of all objects inside
		// 
		// foreach ( $this->objects as $path => $object )
		// 	if ( strpos ( $path, $from->path ) !== false )
		// 		$this->updatePathOn ( $object )
	}

	// private function updatePathOn ( Object $object )
	// {

	// }

	public function __destruct ( )
	{
		file_put_contents ( $this->file, serialize ( $this->objects ) );
	}
}

$fileTree = new FileTree ( __DIR__ . '/' . 'file tree\'s/local file tree' );
// $fileTree2 = new FileTree ( __DIR__ . '/' . 'file tree\'s/dropbox file tree' );
$fileSystem = new FileSystem ( $fileTree );
// $fileSystem2 = new FileSystem ( $fileTree2 );

// $directory->onPath ( 'lionar/application' );

// $fileSystem2->create ( $application );

$fileSystem->create ( $root );
$fileSystem->create ( $application );
$fileSystem->create ( $storage );
$fileSystem->create ( $sports );
$fileSystem->write ( 'my content', $dashboard );
$fileSystem->write ( 'my new contents', $missing );
$fileSystem->move ( $application, $storage );
// $fileSystem->move ( $storage, $application );
// $fileSystem->move ( $storage, $root );

// $fileSystem->move ( $application, $root );
// var_dump ( $fileSystem->fileTree->objects['lionar/storage'] );
// var_dump($fileSystem2->fileTree );


// $file = $fileSystem->files [ 'lionar/application/dashboard.php' ];
// $fileSystem->findFilesIn ( $file );

// class Directories
// {
// 	private $elements = array ( );

// 	public function add ( Directorty $directory )
// 	{

// 	}
// }

// $directory = $fileSystem->fileTree->getDirectoryAtPath ( 'lionar/application' );
// foreach ( $fileSystem->findFilesIn ( $directory ) as $file )
// 	if ( $file->extension === 'php' )
// 		$fileSystem->require ( $file );

// itterate the whole fileSystem from the point of path
// getObjects returns an array, an object graph of the file
// system from path on

// todo:
// 
// 1. require all objects from path
// 2. create the right type from each object
// 3. set the right parent on each object ( null is root )

class LocalFileSystemSeeder
{
	private $path = '';

	public function __construct ( $path )
	{
		$this->path = $path;
	}

	public function getObjects ( )
	{

	}

	private function makeFile ( )
	{

	}

	private function makeDirectory ( )
	{
		$parent = $this->getParentFor ( $path );
		$directory = new Directory ( $name, $parent );
		$this->directories [ ] = $directory;
	}

	private function getParentFor ( $path )
	{
		foreach ( $this->directories as $directory )
			if ( $directory->path === $path )
				return $directory;
	}
}

// if dirname $object === $storedDirectory->path
// $parent = $storedDirectory

array (

	new File ( 'file name.txt' ),
	new Directory ( 'root' ),
	new Directory ( 'application', $root )
);

$seeder = new LocalFileSystemSeeder ( __DIR__ );
new LocalFileSystem ( $seeder->getObjects ( ) );