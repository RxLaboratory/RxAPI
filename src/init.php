<?php
	require_once($__ROOT__."/config.php");
    $RxAPIVersion = "1.4.0";
	$installed = !file_exists($__ROOT__."/install/index.php");

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