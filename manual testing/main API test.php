<?php

use FileSystem\Directory;
use FileSystem\Drivers\LocalFileSystem;
use FileSystem\Disk;
use FileSystem\Disks\Manager as Disks;
use FileSystem\File;
use FileSystem\FileSystem;
use FileSystem\FileTree;
use FileSystem\Manager;
use FileSystem\Root;

use function FileSystem\inside;

require __DIR__ . '/../vendor/autoload.php';


$disks = new  Disks;
$disks->add ( new Disk ( 'local', __DIR__ . '/root', new LocalFileSystem ) );

$manager = new Manager ( $disks );
$tree = new FileTree;

$fileSystem = new FileSystem ( $tree, $manager );


$root = new Root;
$application = new Directory ( 'application', $root );

$fileSystem->make ( $application );

$dashboard = new File ( 'dashboard.php', $application );
$dashboard->write ( 'awesome content' );

$fileSystem->write ( $dashboard );





$themes = new Directory ( 'themes', $root );
$eyedouble = new Directory ( 'eyedouble', $root );

$fileSystem->make ( $themes );
$fileSystem->make ( $eyedouble, inside ( $themes ) );






$storage = new Directory ( 'storage', $root );

$store = new File ( 'store.php', $root );

$fileSystem->make ( $storage );
$fileSystem->write ( $store, inside ( $storage ) );


$store->write ( 'my awesome stored content' );
$fileSystem->write ( $store );


dump ( $fileSystem->findFilesIn ( $application ) );