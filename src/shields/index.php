<?php
/*
		RxVersion
        
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
    
    //prepare reply
	include ("reply.php");

    //connect to database
    include('../db.php');
    $accepted = false;

    if ($installed)
    {
        include ("size.php");
        include ("stats.php");
        include ("funding.php");

        if (!$accepted)
        {
            $reply["label"] = "query";
            $reply["message"] = "unknown";
            $reply["isError"] = true;
            $reply["color"] = "important";
        }
    }
    else
    {
        $reply["label"] = "rxversion";
        $reply["message"] = "not installed";
        $reply["color"] = "critical";
        $reply["isError"] = true;
    }

    unset($reply['success']);
    echo json_encode($reply);

?>