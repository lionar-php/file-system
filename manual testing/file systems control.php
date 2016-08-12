<?php

/**
 * Files and directories that already exist
 */

$objects = array ( 
	$themes = new Directory ( 'themes' ),
	$monastery = new File ( 'monastery.blade.php', $themes ),
);

$fileTree = new FileTree;

foreach ( $objects as $object )
	$fileTree->add ( $object );

$fileSystem = new LocalFileSystem ( $fileTree );

/**
 * disallow any modification on file system objects
 */

$lionar = new Directory ( __DIR__ . '/root' );
$application = new Directory ( 'application' );
$dashboard = new File ( 'dashboard.php' );
$eyedouble = new File ( 'eyedouble.blade.php', 'eyedouble theme content', $themes );

$fileSystem->make ( $lionar );
$fileSystem->make ( $application, inside ( $lionar ) );
$fileSystem->write ( '', to ( $dashboard ), inside ( $application ) );
$fileSystem->write ( '', to ( $eyedouble ), inside ( $themes ) );

/**
 * Ability to read file system objects
 */
$dashboard->content;
$eyedouble->size;



/**
 * How does this work in our when API?
 */

when ( 'i want to make a new theme file', then( apply ( a ( function ( FileSystem $fileSystem, DirectoryFinder $directory, File $theme )
{
	$fileSystem->write ( 'my theme content', to ( $theme ), inside ( $directory->named ( 'themes' ) ) );	
}))));

when ( 'i want to make a new powerpoint', then( apply ( a ( function ( FileSystem $fileSystem, DirectoryFinder $directory, Presentation $presentation, PPTX $file )
{
	$fileSystem->write ( $presentation, to ( $file ), inside ( $directory->named ( 'my documents' ) ) );	
}))));


class FileSystem
{
	public function write ( $content, File $file, Directory $directory = null )
	{
		foreach ( array ( $file, $directory ) as $object )
			if ( ! $this->fileTree->has ( $object ) )
				throw new NonExistentException ( 'you fucked it' );
		$file->write ( $content );
	}
}

class LocalFileSystem extends FileSystem
{
	public function write ( $contents, File $file, Directory $directory = null )
	{
		parent::write ( $contents, $file, $directory );
		file_put_contents ( $file->path, $contents );
	}
}



$dropbox->write ( $dashboard ); // throws exception...

// class LocalFileSystem extends FileSystem
// {
// 	public function write ( $content, File $file, Directory $directory )
// 	{
		
// 	}
// }