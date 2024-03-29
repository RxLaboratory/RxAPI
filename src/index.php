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

    $__ROOT__ = dirname(__FILE__);
    
    //configuration and init 
    require_once ("config.php");
    require_once ("functions.php");
    require_once ("init.php");

    //prepare reply
    require_once ("reply.php");

    //connect to database
    require_once('db.php');

    if ($installed)
    {
        include ("getVersion.php");
        include ("getStats.php");

        if (!$reply["accepted"])
        {
            $reply["message"] = "Unknown query";
        }
    }
    else
    {
        $reply["message"] = "This RxVersion server is not installed yet.";
    }
    
    echo json_encode($reply);
?>