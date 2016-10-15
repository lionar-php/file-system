<?php

use FileSystem\Directory;
use FileSystem\File;
use FileSystem\Root;

require __DIR__ . '/../vendor/autoload.php';

$root = new Root;
$application = new Directory ( 'application', $root );
$dashboard = new File ( 'dashboard.php', $application );

$dashboard->moveTo ( $root );

// $application->remove ( $dashboard );


$dashboard->renameTo ( 'new-dashboard.php' );

dump ( $root->objects [ 'application' ]->parent );

dump ( $dashboard->name );