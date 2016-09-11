<?php

$stat = stat(__DIR__);
echo 'Modification time: ' . $stat['mtime'];