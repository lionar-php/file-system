<?php

$application = new LocalDirectory ( 'application' );
$dashboard = new LocalFile ( 'dashboard.php', $application );

$dashboard->write ( 'hello world' );
echo $dashboard->content; // hello world

class Engine
{
	public function __construct ( Directory $cache )
	{
		$this->cache = $cache;
	}

	public function read ( File $template )
	{
		echo $template->content;
		$this->cache->add (  ); // how to know what kind of file to add?
	}
}

$template = new DropboxFile ( 'dashboard.blade.php' );
$template->write ( '<h1>The dashboard</h1>' );

$engine = new Engine;
$engine->read ( $template );

