<?php

use FileSystem\Root;
use FileSystem\Directory;
use FileSystem\File;

require __DIR__ . '/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Removing an object.
|--------------------------------------------------------------------------
|
| Removing an object from it's parent directory resolves in
| an invalid object since it has no longer a parent. We should
| be able to unset all but we cannot.
*/

$root = new Root;
$application = new Directory ( 'application', $root );
$dashboard = new File ( 'dashboard.php', $application );

$application->remove ( $dashboard );

dd ( $dashboard );


/** 
 * Speculation
 * -------------------------------------------------------------------------
 */

/**
 * What do we need to do with $dashboard's parent here? It should not be null
 * because a file always has a directory parent. The best solution is to delete it
 * completely (removing all references) but we do not have that possibility.
 */

/** 
 * Solution
 * -------------------------------------------------------------------------
 */

/**
 * Solved, Leaving the object intact is no problem at all, just don't remove the parent.
 * The object can still be used to do whatever the developper wants with it, he just needs
 * to understand that it will no longer be referenced inside the parent's objects array.
 */