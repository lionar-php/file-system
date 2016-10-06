<?php

save ( 'files' )->inside ( Directory::at ( 'application' ) )->onlyto ( array (

	$diskManager->get ( 'local' ),
) );

$rule = new Rule ( 
	'saving application files locally', 
	'Only save application files locally these files are php files',
	'files', 
	$application
);

// now all files inside '$application' are only saved in the 'local' disk
$rule->restrictTo ( array ( $diskManager->get ( 'local' ) ) );



$rule = new Rule (

	'Managing application objects',
	'This rule decides which disks are allowed to save application objects',
	'objects',
	$application,
	array ( 'allowed disks' => array (

		$diskManager->get ( 'local' ),
	) )
);

$rule->allow ( $diskManager->get ( 'local' ) );
$rule->disallow ( $diskManager->get ( 'dropbox' ) );



allow ( array ( $diskManager->get ( 'local' ) ) )
	->to ( 'write objects' )
	->inside ( $application )
	->named ( 'Managing application objects' )
	->andDescribedAs ( 'This rule decides which disks are allowed to save application objects' );

disallow ( array ( $diskManager->get ( 'dropbox' ) ) )
	->to ( 'write files' )
	->inside ( $themes )
	->named ( 'Disallowed theme disks' )
	->andDescribedAs ( 'This rule decides which disks are allowed to write files inside the themes directory' );

// if there is a rule for a directory wherein an operation is going to
// take place we will apply that rule. If there are multiple rules for
// that directory we will only apply the rule that is most specific.
// otherwise no rules are applied and the operation will take place in
// all the disk manager's registered disks.
// 
// So, by default all disks are allowed unless there is a rule, in that case 
// the rule totally decides which disks are allowed to do the operation.


class Rule
{
	private $allowed = array (
		new Disk ( 'local' )
	);

	public function __construct ( $name, $description, $type, Directory $directory )
	{

	}

	public function allow ( array $disks )
	{
		// add to allowed
	}

	public function restrictTo ( array $disks )
	{

	}
}

$rule->allow (  )