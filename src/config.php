<?php
    /*
		RxVersion
        
        This program is licensed under the GNU General Public License.

        Copyright (C) 20202-2021 Nicolas Dufresne and Contributors.

        This program is free software;
        you can redistribute it and/or modify it
        under the terms of the GNU General Public License
        as published by the Free Software Foundation;
        either version 3 of the License, or (at your option) any later version.

        This program is distributed in the hope that it will be useful,
        but WITHOUT ANY WARRANTY; without even the implied warranty of
        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
        See the GNU General Public License for more details.

        You should have received a copy of the *GNU General Public License* along with this program.
        If not, see http://www.gnu.org/licenses/.
	*/

    // Edit this configuration file before running the install script at /install/index.php

	// === DEV MODE ===
	// Activates printing the SQL & PHP errors.
	// For security reasons, it is important to set this to false in production mode
	$devMode = true;

	// ==== SQL SETTINGS ====

	// Host URL
	$sqlHost = "localhost";
	$sqlPort = 3306;
	// Database name
	$sqlDBName = "rxversion";
	// User
	$sqlUser = "rxversion";
	// Password
	$sqlpassword = "eEGWRk7i";
	// Table prefix
	// DO NOT CHANGE THIS, not working yet
	$tablePrefix = "rxv";

	// ==== Github Settings ====
	$ghUsername = "YourUserName";
	$ghToken = "YourPersonnalAccessToken";
	$ghUser = "RxLaboratory";

	// ==== Patreon Settings ====
	// Leave empty if you don't use Patreon
	// Otherwise, create an application on Patreon
	// And add the Creator's access token here
	$patreonToken = "";
?>
