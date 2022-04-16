<?php

    if (hasArg( "size" ))
    {
        $accepted = true;
        $name = getArg("name");
        $asset = getArg("asset", 0);

        if ( $name != "" )
        {
            // Get the update info
            $rep = $db->prepare( "SELECT
                    {$appsTable}.`ghUser`,
                    {$appsTable}.`ghRepo`
                FROM {$appsTable}
                WHERE {$appsTable}.`name` = :name ;"
                );

            $rep->bindValue(':name', $name, PDO::PARAM_STR);
            $ok = sqlRequest( $rep );

            if ($ok)
            {
                if ($r = $rep->fetch()) 
                {
                    $reply['label'] = "size";
                    $reply['message'] = "unknown";
                    $reply['isError'] = false;
                    $reply['color'] = "lightgrey";
                    
                    $user = $r["ghUser"];
                    $repo = $r["ghRepo"];
                    // Get Github data
                    $gh = ghRequest( "https://api.github.com/repos/$user/$repo/releases" );
                    $gh = json_decode($gh, true);
                    if(count($gh) > 0) {
                        $release = $gh[0];
                        if (count($release["assets"]) > $asset) {
                            $asset = $release["assets"][$asset];
                            $s = $asset["size"];
                            if ($s < 1024) $s = "{$s} B";
                            else if ($s <= 1048576) {
                                $s = round($s / 1024, 0);
                                $s = "{$s} kB";
                            }
                            else if ($s <= 1073741824) {
                                $s = round($s / 1048576, 1);
                                $s = "{$s} MB";
                            }
                            else if ($s <= 1099511628000) {
                                $s = round($s / 1073741824, 2);
                                $s = "{$s} GB";
                            }
                            $reply['message'] = $s;
                            $reply['color'] = "informational";
                        }

                    }
                }
            }

            $rep->closeCursor();
        }
    }
?>