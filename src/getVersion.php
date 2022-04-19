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

    function ghGetReleaseReply($release, $version) {
        global $reply;
        global $donateURL;
        global $orgURL;
        global $orgURL;
        // default values
        $reply['donateURL'] = $donateURL;
        $reply['downloadURL'] = $orgURL;
        $reply['changelogURL'] = $orgURL;

        // Parse version
        $newVersion = $release['tagName'];
        if (startsWith($newVersion, 'v')) $newVersion = substr($newVersion, 1);

        // Parse description
        $description = $release['description'];
        $description = explode("----", $description);
        if (count($description) > 1) {
            $links = end($description);
            $links = explode("\n", $links);
            foreach($links as $link) {
                $link = str_replace("\r", "", $link);
                $link = explode(': ', $link);
                if (count($link) == 2 && $link[0] == 'download') $reply['downloadURL'] = $link[1];
                if (count($link) == 2 && $link[0] == 'changelog') $reply['changelogURL'] = $link[1];
                if (count($link) == 2 && $link[0] == 'donate') $reply['donateURL'] = $link[1];
            }
        }
        $description = $description[0];

        $reply['update'] = checkVersion( $version, $newVersion );
        $reply['version'] = $newVersion;
        $reply['newName'] = $release['name'];
        $reply['description'] = $description;
        $reply['date'] = $release['publishedAt'];
    }

    function checkVersion( $version, $testVersion )
    {
        $reV = '/^v?(\d+)\.?(\d*)\.?(\d*)\D?(\S*)/i';

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
        $prerelease = hasArg("prerelease");
        
        if ( checkArgs( array( $name, $version ) ) )
        {
            $reply['update'] = false;
            $reply['name'] = $name;
            $appId = 0;
            $found = false;

            // Github data
            $ghToolUser = $ghUser;
            $ghRepo = $name;

            // Check if we've data in the DB to override defaults
            // Get the info
            $rep = $db->prepare( "SELECT
                    {$appsTable}.`id`,
                    {$appsTable}.`ghUser`,
                    {$appsTable}.`ghRepo`
                FROM {$appsTable}
                WHERE {$appsTable}.`name` = :name;"
                );
            $rep->bindValue(':name', $name, PDO::PARAM_STR);
            $ok = sqlRequest( $rep, "Successful request." );
            if ($ok)
            {
                if ($v = $rep->fetch()) {
                    if($v['ghUser']) $ghToolUser = $v['ghUser'];
                    if($v['ghRepo']) $ghRepo = $v['ghRepo'];
                }
                $rep->closeCursor();
            }

            // Get update info from Github
            $query = <<<JSON
            {
                repository(owner: "$ghToolUser", name: "$ghRepo") {
                    releases(first: 50, orderBy: {field: CREATED_AT, direction: DESC}) {
                        nodes {
                            publishedAt,
                            tagName,
                            description,
                            isPrerelease,
                            name
                        }
                    }
                }
            }
            JSON;
            $variables = '';
            $query = json_encode(['query' => $query, 'variables' => $variables]);

            $gh = ghGraphQL( $query );
            $gh = json_decode($gh, true);

            $releases = $gh['data']['repository']['releases']['nodes'];

            foreach($releases as $release) {
                if ($prerelease || !$release['isPrerelease']) {
                    
                    ghGetReleaseReply($release, $version);
                    $found = true;
                    break;
                }
            }
            // If not found and not prerelease, pick the latest prerelease anyway
            if (!$found && count($releases) > 0) {
                ghGetReleaseReply($releases[0], $version);
                $found = true;
            }

            if (!$found)
            {
                $reply['success'] = false;
                $reply['message'] = "It seems this is an unknown software or no public version has been published yet.";
            }

            // Update stats
            $rep = $db->prepare( "INSERT INTO {$statsTable} (`appName`, `version`, `os`, `osVersion`, `host`, `hostVersion`)
                VALUES (
                    :name,
                    :version,
                    :os,
                    :osVersion,
                    :host,
                    :hostVersion
                );");
            $rep->bindValue(':name', trim($name), PDO::PARAM_STR);
            $rep->bindValue(':version', trim($version), PDO::PARAM_STR);
            $rep->bindValue(':os', trim($os), PDO::PARAM_STR);
            $rep->bindValue(':osVersion', trim($osVersion), PDO::PARAM_STR);
            $rep->bindValue(':host', trim($host), PDO::PARAM_STR);
            $rep->bindValue(':hostVersion', trim($hostVersion), PDO::PARAM_STR);
            $rep->execute();
            $rep->closeCursor();
            
            // Add funding info
            // GITHUB
            $fund = ghIncome();
            // PATREON
            $fund += patreonIncome();
            // WOOCOMMERCE
            $fund += wcIncome(); 

            $reply['monthlyFund'] = $fund;
            $reply['fundingGoal'] = $fundingGoal;
                
        }

    }

?>