<?php


namespace FileSystem\Tools\Generators\Tests;

use FileSystem\Tools\Generators\FileTreeGenerator;
use FileSystem\Root;
use Mockery;
use org\bovigo\vfs\vfsStream as VFS;
use Testing\TestCase;

class FileTreeGeneratorTest extends TestCase
{
	private $root = null;
	private $structure = array (
		'application' => array (
			'sports'			=> array (
				'showing the exercise creation form.php' 	=> 'exercise creation form',
				'creating an exercise'				=> 'create the exercise',	
			),
			'dashboard.php'	=> '<h1>Dashboard</h1>'
		),
		'themes' => array (
			'eyedouble'		=> 'Eyedouble\'s theme'
		),
		'storage'	=> array (

		),
	);

	public function setUp ( )
	{
		VFS::setup ( 'root' );
		$this->root = VFS::create ( $this->structure );

		$this->generator = new FileTreeGenerator;
	}

	/*
	|--------------------------------------------------------------------------
	| Adding directories.
	|--------------------------------------------------------------------------
	|
	| Here we test we can add directories that will be treated
	| as root directory.
	*/

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 * @dataProvider nonDirectories
	 */
	public function add_withNonExistentDirectory_throwsException ( $object )
	{
		$this->generator->add ( $object );
	}

	/**
	 * @test
	 */
	public function add_withExistingDirectory_addsDirectoryToGeneratorAsDirectoryObject ( )
	{
		$directory = VFS::url ( 'root/storage' );
		$this->generator->add ( $directory );

		assertThat ( $this->generator->rooted, hasKey ( $directory  ) );
		assertThat ( $this->generator->rooted [ $directory ], is ( anInstanceOf ( Root::class ) ) );
	}

	/*
	|--------------------------------------------------------------------------
	| generating file tree.
	|--------------------------------------------------------------------------
	|
	| Here we test that we can generate a correct file tree
	| with root, directory and file objects.
	*/

	/**
	 * @test
	 */
	public function generate_withRootedDirectories_returnsFileTree ( )
	{

	}




	/*
	|--------------------------------------------------------------------------
	| Data providers.
	|--------------------------------------------------------------------------
	|
	| 
	*/

	public function nonDirectories ( )
	{
		return array (
			array ( VFS::url ( 'root/non-existent-object' )  ),
			array ( VFS::url ( 'root/file' )  )
		);
	}

}