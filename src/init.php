<?php
    $rxVersionVersion = "0.0.1-Dev";
	$installed = !file_exists("install/index.php");

	if ($devMode)
	{
		ini_set('display_errors', '1');
		ini_set('display_startup_errors', '1');
		error_reporting(E_ALL);
	}

	//add the "_" after table prefix if needed
	setupTablePrefix();

	//build table names
	$versionsTable = $tablePrefix . "versions";
	$statsTable = $tablePrefix . "stats";	
	$appsTable = $tablePrefix . "apps";	
?>