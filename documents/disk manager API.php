<?php

$manager->add ( new Disk ( 'local', __DIR__, new LocalFileSystem ) );

$manager->get ( 'local' );