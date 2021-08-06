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

    function checkOS( $os, $testOS )
    {
        $os = strtolower($os);
        $testOS = strtolower($testOS);
       
        if ($testOS == 'all') return true;
        if ($os == 'all' || $os == 'any' || $os == '') return true;

        if ($testOS == $os) return true;

        if ($testOS == 'ios' || $testOS == 'android' || $testOS == 'win' || $testOS == 'mac') return false;

        return true;
    }

    function checkHost( $host, $testHost )
    {
        $host = strtolower($host);
        $testHost = strtolower($testHost);
       
        if ($testHost == 'all') return true;
        if ($host == 'all' || $host == 'any' || $host == '') return true;

        return $testHost == $host;
    }

    function checkVersion( $version, $testVersion )
    {
        $reV = '/^(\d+)\.?(\d*)\.?(\d*)\D?(\S*)/i';

        // Get info from versions
        preg_match( $reV, $version, $versionMatches );
        preg_match( $reV, $testVersion, $testMatches );
        
        // Major
        if ( intVal($versionMatches[1]) < intVal($testMatches[1]) ) return true;
        if ( intVal($versionMatches[1]) > intVal($testMatches[1]) ) return false;

        // Minor
        if ( intVal($versionMatches[2]) < intVal($testMatches[2]) ) return true;
        if ( intVal($versionMatches[2]) > intVal($testMatches[2]) ) return false;

        // Patch
        if ( intVal($versionMatches[3]) < intVal($testMatches[3]) ) return true;
        if ( intVal($versionMatches[3]) > intVal($testMatches[3]) ) return false;

        // Build / other info
        $vBuild = $versionMatches[4];
        $tBuild = $testMatches[4];

        // Same buikd
        if ($vBuild == $tBuild) return false;

        // A number is always considered higher version than a string
        if (is_numeric($tBuild) && !is_numeric($vBuild)) return true;
        if (!is_numeric($tBuild) && is_numeric($vBuild)) return false;

        // Both numbers, the highest the winner; equals means do not update
        if (is_numeric($tBuild) && is_numeric($vBuild))
        {
            if( intval($tBuild) > intval($vBuild) ) return true;
            else return false;
        }

        // Both strings, one empty. Empty is always the winner
        if ($tBuild == '') return true;
        if ($vBuild == '') return false;

        // Both strings, alphabetical order
        if (strcasecmp($vBuild, $tBuild) < 0) return true;
        return false;
    }

    if (hasArg("getVersion"))
	{
        $reply["accepted"] = true;

        $name = getArg("name");
        $version = getArg("version");
        $os = getArg("os");
        $osVersion = getArg("osVersion");
        $host = getArg("host");
        $hostVersion = getArg("hostVersion");
        
        if ( checkArgs( array( $name, $version, $os ) ) )
        {
            // Get the update info
            $rep = $db->prepare( "SELECT
                    {$appsTable}.`id`,
                    {$versionsTable}.`version`,
                    {$appsTable}.`os`,
                    {$appsTable}.`host`,
                    {$versionsTable}.`description`,
                    {$versionsTable}.`downloadURL`,
                    {$versionsTable}.`changelogURL`,
                    {$versionsTable}.`donateURL`,
                    {$versionsTable}.`date`
                FROM {$versionsTable}
                JOIN {$appsTable} ON {$appsTable}.`id` = {$versionsTable}.`app`
                WHERE {$appsTable}.`name` = :name
                ORDER BY `date` DESC;"
                );

            $rep->bindValue(':name', $name, PDO::PARAM_STR);
            $ok = sqlRequest( $rep, "Successful request." );

            if ($ok)
            {
                $reply['update'] = false;
                $appId = 0;
                $found = false;

                // Look for the latest version for the same os
                while ($v = $rep->fetch())
                {
                    $appId = (int)$v['id'];
                    // First, check os
                    if (!checkOS( $os, $v['os'])) continue;
                    // Check host
                    if (!checkHost( $host, $v['host'])) continue;

                    // Found os, check version
                    $reply['update'] = checkVersion( $version, $v['version'] );
                    // Populate reply
                    $reply['version'] = $v['version'];
                    $reply['name'] = $name;
                    $reply['description'] = $v['description'];
                    $reply['downloadURL'] = $v['downloadURL'];
                    $reply['changelogURL'] = $v['changelogURL'];
                    $reply['donateURL'] = $v['donateURL'];
                    $reply['date'] = $v['date'];

                    $found = true;
                    break;
                }

                if (!$found)
                {
                    $reply['success'] = false;
                    $reply['message'] = "It seems this is an unknown software or no version has been published yet, can't check version.";
                }

                if($appId > 0)
                {
                    // Update stats
                    $rep = $db->prepare( "INSERT INTO {$statsTable} (`app`, `appName`, `version`, `os`, `osVersion`, `host`, `hostVersion`)
                        VALUES (
                            :id,
                            :name,
                            :version,
                            :os,
                            :osVersion,
                            :host,
                            :hostVersion
                        );");
                    $rep->bindValue(':id', $appId, PDO::PARAM_INT);
                    $rep->bindValue(':name', trim($name), PDO::PARAM_STR);
                    $rep->bindValue(':version', trim($version), PDO::PARAM_STR);
                    $rep->bindValue(':os', trim($os), PDO::PARAM_STR);
                    $rep->bindValue(':osVersion', trim($osVersion), PDO::PARAM_STR);
                    $rep->bindValue(':host', trim($host), PDO::PARAM_STR);
                    $rep->bindValue(':hostVersion', trim($hostVersion), PDO::PARAM_STR);
                    $rep->execute();
                    $rep->closeCursor();
                }
                

                
            }
            else $rep->closeCursor();
        }

    }

?>