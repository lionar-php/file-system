<?php	

public function findFilesDirectlyIn ( Directory $directory )
{
	$files = array ( );

	foreach ( $directory->files as $file )
		if ( dirname ( $file ) === $directory->path )
			$files [ ] = $file;
		
	return $files;
}

/**
 * @test
 */
public function findFilesIn_withExistentDirectoryForDirectoryArgument_returnsAllFilesInThatDirectory ( )
{
	$allFilesInDirectory =  array ( new File ( 'vfs://root/blog\post.php' ), new File ( 'vfs://root/blog\author.php' ), new File ( 'vfs://root/blog\permissions\authors permissions.php' ) );
	$expectedFiles =  array ( new File ( 'vfs://root/blog\post.php' ), new File ( 'vfs://root/blog\author.php' ) );


	$directory = Mockery::mock ( 'Lionar\\FileSystem\\Directory', array ( VfsStream::url ( 'root/blog' ) ) );
	$directory->files = $allFilesInDirectory;
	$files = $this->fileSystem->findFilesIn ( $directory );
	assertThat ( $files, is ( equalTo( $expectedFiles ) ) );
}