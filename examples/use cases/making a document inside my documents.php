<?php

use Application\Documents\Document; // extends file
use Application\Documents\MyDocuments; // extends directory
use FileSystem\FileSystem;

when ( 'i want to write a document', then( apply ( a ( 

function ( FileSystem $fileSystem, MyDocuments $myDocuments, Document $document )
{
	$fileSystem->write ( $document, inside ( $myDocuments ) );
} ) ) ) );
