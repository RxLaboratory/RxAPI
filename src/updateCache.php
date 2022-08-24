<?php    
    /*
        RxAPI
        
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
    
    $__ROOT__ = dirname(__FILE__);
    require_once ("config.php");
    require_once ("functions.php");
    require_once ("init.php");
    //connect to database
    require_once('db.php');
        
    if (hasArg("ghBackers")) ghBackers(true);
    else if (hasArg("ghIncome")) ghIncome(true);
    else if (hasArg("patreonBackers")) patreonBackers(true);
    else if (hasArg("patreonIncome")) patreonIncome(true);
    else if (hasArg("wcBackers")) wcBackers(true);
    else if (hasArg("wcIncome")) wcIncome(true);
    else if (hasArg("stripeSubscriptions")) stripeSubscriptions(true);
    else if (hasArg("stripeIncome")) stripeIncome(true);
    else if (hasArg("getStats")) {
    $from = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
    $to = date("Y-m-d H:i:s");
    getStats($from, $to, true);
    }
?>