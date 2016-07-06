<?php

use Lionar\FileSystem\Directory;
use Lionar\FileSystem\Object;
use Lionar\FileSystem\File;

require __DIR__ . '/../vendor/autoload.php';

$oldmask = umask(0);
// mkdir("test", 0777);
// umask($oldmask);



$root = new Directory ( 'lionar', null );
$application = new Directory ( 'application', $root );
$storage = new Directory ( 'storage', $root );
$sports = new Directory ( 'sports', $application );
$dashboard = new File ( 'dashboard.php', $application );
$missing = new File ( 'missing.php', $application );

class FileSystem
{
	private $directories, $files = array ( ); // if its in here, it should exist

	public function create ( Directory $directory )
	{
		$this->directories [ ] = $directory;
		if ( ! file_exists ( $directory->path ) or ! is_dir ( $directory->path ) )
			mkdir ( $directory->path );
	}

	public function write ( $content, File $to )
	{
		// do some permission solving also
		$this->files [ ] = $to;
		$to->write ( $content );
		file_put_contents ( $to->path, $to->content );
	}

	public function move ( Object $from, Directory $to )
	{
		if ( ! in_array ( $from, $this->directories ) or ! in_array ( $to, $this->directories ) ) // if its not in array it doesnt exist
			return false;
		
		rename ( $from->path, $to->path . '/' . $from->name );
		$from->moveTo ( $to );
	}
}

class DropBox extends FileSystem
{

}

$fileSystem = new FileSystem;
$dropBox = new DropBox;

$dropBox->create ( $application );

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
var_dump ( $fileSystem );
var_dump($dropBox);