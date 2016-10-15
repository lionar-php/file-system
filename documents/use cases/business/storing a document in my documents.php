<?php

namespace Business;


class Document extends File
{

}

class MyDocuments extends Directory
{

}


/** ------------------------------------------------------------------------- */


use Business\Document;
use Business\MyDocuments;
use FileSystem\FileSystem;


when ( 'i want to write a new document', then ( apply ( a ( 

function ( FileSystem $fileSystem, MyDocuments $myDocuments, Document $document )
{
	$fileSystem->write ( $document, inside ( $myDocuments ) );
} ) ) ) );