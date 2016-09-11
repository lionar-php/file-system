<?php


// directory based
class Engine
{
	private $themes, $cache = null;

	public function __construct ( Directory $themes, Directory $cache )
	{
		if ( ! $themes->isReadable )
			throw new NotReadableException ( 'the themes directory is not readable' );

		if ( ! $cache->isReadable )
			throw new NotReadableException ( 'the cache directory is not readable' );

		if ( ! $cache->isWritable )
			throw new NotWritableException ( 'the cache directory is not writable' );

		$this->themes = $themes;
		$this->cache = $cache; 
		// directory exists.. is a valid directory can take any file..
	}

	public function render ( File $template, array $data = array ( ) )
	{
		echo $this->fileSystem->read ( $template );
	}
}

$templates = [

	new File ( 'dashboard.blade.php' ),
	new File ( 'a list of exercises.blade.php' ),
];

$template = $templates [ 'dashboard.blade.php' ];  // existent file
$engine->render ( $template );

// file system based
class Trainer
{
	private $fileSystem, $exercises = null;

	public function __construct ( FileSystem $fileSystem, File $exercises )
	{
		$this->fileSystem = $fileSystem;
		$this->exercises = $exercises;
	}

	public function remember ( Exercise $exercise )
	{
		$this->fileSystem->write ( serialize ( $exercise ), to ( $this->exercises ) );
	} 
}