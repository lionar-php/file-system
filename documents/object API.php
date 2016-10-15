<?php

// construction
$root = new Root;
$application = new Directory ( 'application', $root );
$dashboard = new File ( 'dashboard.php', $application );


// modification
$fileSystem->make ( $application );
$fileSystem->write (  'my contents', to ( $dashboard ) );

$fileSystem->move ( $dashboard, to ( $root ) );

$fileSystem->delete ( $file );