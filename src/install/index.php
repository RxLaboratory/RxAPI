<?php

	/*
		RxVersion
		Installs the SQL Database
	*/

    //connect to database

    echo ( "Connecting to the database...<br />" );

    $__ROOT__ = dirname(dirname(__FILE__));
    require_once($__ROOT__."/config.php");
    require_once($__ROOT__."/functions.php");
    require_once($__ROOT__."/db.php");

    echo ( "Database found and working!<br />" );

    setupTablePrefix();

    echo ( "Writing the new database scheme...<br />" );

    $sql = file_get_contents('structure.sql');
    // Run the installer SQL Script
    $qr = $db->exec($sql);
    
    if ( $qr === false )
    {
        echo( "Sorry, something went wrong while writing the database. Here's the error:<br />" );
        die( print_r($db->errorInfo(), true) );
    }

    echo ( "Database tables are ready!<br />" );

    echo ( "<p>The RxVersion server has been correctly installed, you can now <strong>remove the <code>install</code> directory</strong>.</p>" );
?>