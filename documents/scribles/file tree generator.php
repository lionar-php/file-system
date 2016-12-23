<?php

$generator = new FileTreeGenerator ( array ( '/application', '/themes/pages' ) );
$generator->add ( $directory );
$generator->generate (  );



use FileSystem\Root;
use FileSystem\File;
use FileSystem\Directory;

$tree = array ( 

	$root 			= new Root ( '/' ),
	$application		= new Directory ( 'application', $root ),
	$dashboard		= new File ( 'showing the dashboard.php', $application, "echo '<h1>Dashboard</h1>';" ), 
);

// what do we pick as root directory???
// all of those passed will be stored as root directory.

class FileTreeGenerator
{
	private $roots = array ( );
}

$structure = array(
  	'Core' => array(
        		
        		'AbstractFactory' => array(
          			'test.php'    => 'some text content',
          			'other.php'   => 'Some more text content',
          			'Invalid.csv' => 'Something else',
         		),
        		'AnEmptyFolder'   => array(),
        		'badlocation.php' => 'some bad content',
 	)
);


new Directory ( 'name', $parent );
new File ( 'name.extension', $parent, $content );

class ObjectFactory
{
	public function create ( $name, $parent = null, $content = '' )
	{
		
	}

	public function createFromArray ( array $tree )
	{
		
	}
}