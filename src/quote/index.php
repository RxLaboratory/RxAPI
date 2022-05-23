<?php
/*
		RxAPI
        
        This program is licensed under the GNU General Public License.

        Copyright (C) 2020-2022 Nicolas Dufresne and Contributors.

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

    //configuration and init 
	include ("../config.php");
    include ("../functions.php");
    include ("../init.php");

    // Parse quotes
    $quotesFile = fopen("quotes.json", "r") or die("Quotes not found.");
    $quotes = fread($quotesFile,filesize("quotes.json"));
    fclose($quotesFile);
    $quotes = json_decode($quotes);

    // Choose random quote
    $rdm = random_int(0,count($quotes) - 1);

    // And print
    $reply = $quotes[$rdm];
    echo json_encode($reply);
?>