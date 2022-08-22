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

    if (hasArg("ghBackers")) ghBackers(true);
    if (hasArg("ghIncome")) ghIncome(true);
    if (hasArg("patreonBackers")) patreonBackers(true);
    if (hasArg("patreonIncome")) patreonIncome(true);
    if (hasArg("wpBackers")) wpBackers(true);
    if (hasArg("wpIncome")) wpIncome(true);
    if (hasArg("wcBackers")) wpIncome(true);
    if (hasArg("wcIncome")) wcIncome(true);
    if (hasArg("getStats")) {
        $from = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
        $to = date("Y-m-d H:i:s");
        getStats($from, $to, true);
    }
?>