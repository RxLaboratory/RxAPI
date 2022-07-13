<?php
    if (hasArg( "winstats" ))
    {
        $accepted = true;
        $reply['label'] = "Win";
        $reply['message'] = "unknown";
        $reply['isError'] = false;
        $reply['color'] = "lightgrey";
        $reply['namedLogo'] = "windows";

        $stats = getStats(date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))), date("Y-m-d H:i:s"));
        if ($stats) {
            $reply['message'] = $stats["winRatio"] . " %";
            $reply['color'] = "informational";
            unset($reply["success"]);
        }
    }
    if (hasArg( "macstats" ))
    {
        $accepted = true;
        $reply['label'] = "Mac";
        $reply['message'] = "unknown";
        $reply['isError'] = false;
        $reply['color'] = "lightgrey";
        $reply['namedLogo'] = "apple";

        $stats = getStats(date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))), date("Y-m-d H:i:s"));
        if ($stats) {
            $reply['message'] = $stats["macRatio"] . " %";
            $reply['color'] = "informational";
            unset($reply["success"]);
        }

        
    }
    if (hasArg( "linuxstats" ))
    {
        $accepted = true;
        $reply['label'] = "Linux";
        $reply['message'] = "unknown";
        $reply['isError'] = false;
        $reply['color'] = "lightgrey";
        $reply['namedLogo'] = "linux";

        $stats = getStats(date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))), date("Y-m-d H:i:s"));
        if ($stats) {
            $reply['message'] = $stats["linuxRatio"] . " %";
            $reply['color'] = "informational";
            unset($reply["success"]);
        }
    }
?>