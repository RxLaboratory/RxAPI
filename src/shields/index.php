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

    $__ROOT__ = dirname(dirname(__FILE__));
    require_once($__ROOT__."/config.php");
    require_once($__ROOT__."/functions.php");
    require_once($__ROOT__."/init.php");
   
    //prepare reply
	require_once ($__ROOT__."/shields/reply.php");

    //connect to database
    require_once($__ROOT__."/db.php");
    $accepted = false;

    if ($installed)
    {
        include ($__ROOT__."/shields/size.php");
        include ($__ROOT__."/shields/stats.php");
        include ($__ROOT__."/shields/funding.php");

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