<?php
    require_once($__ROOT__."/functions.php");

    if (hasArg( "size" ))
    {
        $accepted = true;
        $name = getArg("name");
        $asset = getArg("asset", 0);

        $reply['label'] = "size";
        $reply['message'] = "unknown";
        $reply['isError'] = false;
        $reply['color'] = "lightgrey";

        if ( $name != "" )
        {
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
            $ok = sqlRequest( $rep );

            if ($ok)
            {
                if ($v = $rep->fetch()) {
                    if($v['ghUser']) $ghToolUser = $v['ghUser'];
                    if($v['ghRepo']) $ghRepo = $v['ghRepo'];
                }
                $rep->closeCursor();
            }
              
            // Get Github data
            $gh = ghRequest( "https://api.github.com/repos/$ghToolUser/$ghRepo/releases" );
            $gh = json_decode($gh, true);
            foreach($gh as $release) {
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
                    // Get file extension
                    $assetName = $asset["name"];
                    $explodedName = explode('.', $assetName);
                    $ext = end($explodedName);
                    $reply['message'] = "$s (.{$ext})";
                    $reply['color'] = "informational";
                    break;
                }
            }
        }
    }
?>