<?php
    $RxAPIVersion = "1.2.0";
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
	$statsTable = $tablePrefix . "stats";	
	$appsTable = $tablePrefix . "apps";	
?>