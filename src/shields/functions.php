<?php
    /**
     * Tests if a string starts with a substring
     */
    function startsWith( $string, $substring ) {
        $length = strlen( $substring );
        return substr( $string, 0, $length ) === $substring;
    }

    /**
        * Tests if a string ends with a substring
        */
    function endsWith( $string, $substring ) {
        $length = strlen( $substring );
        if( !$length ) {
            return true;
        }
        return substr( $string, -$length ) === $substring;
    }

    /**
        * Prepares the prefix for SQL table names (adds a "_" at the end if needed)
        */
    function setupTablePrefix() {
        global $tablePrefix;
        if (strlen($tablePrefix) > 0 && !endsWith($tablePrefix, "_")) $tablePrefix = $tablePrefix . "_";
    }


    /**
    * Check if the URL has the given arg
    */
    function hasArg( $name )
    {
        return isset($_GET[$name]);
    }
        
    /**
    * Gets an argument from the url
    */
    function getArg($name, $defaultValue = "")
    {
        global $contentInPost, $contentAsJson, $bodyContent;

        $decordedArg = "";

        // First, try from URL
        if ( hasArg( $name ) )
        {
            $decordedArg = rawurldecode ( $_GET[$name] );
        }
        
        if ($decordedArg == "") return $defaultValue;       

        return $decordedArg;
    }

    function checkArgs( $arglist )
    {
        global $reply;

        $ok = true;
        foreach( $arglist as $arg )
        {
            if ($arg == "")
            {
                $ok = false;
                break;
            }
        }
        if (!$ok)
        {
            $reply["message"] = "invalid request, missing values";
            $reply["label"] = "rxversion";
            $reply["isError"] = true;
            $reply["color"] = "important";
        }
        return $ok;
    }

    function sqlRequest( $request, $debug = false )
    {
        global $reply;

        if ($debug) $request->debugDumpParams();

        $ok = $request->execute();

        if (!$ok)
        {
            $reply["label"] = "sql query";
            $reply["message"] = "error";
            $reply["isError"] = true;
            $reply["color"] = "important";
            if ($debug) $reply["sqlError"] = $rep->errorInfo()[2];
        }
        
        return $ok;
    }

    function ghRequest( $url ) {
        global $ghUsername;
        global $ghToken;

        $userAgent = 'RxVersions/2.0 (PHP)';

        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_USERAGENT, $userAgent );
        curl_setopt($ch, CURLOPT_USERPWD, "{$ghUsername}:{$ghToken}");
        curl_setopt($ch, CURLOPT_URL, $url);
        // Set so curl_exec returns the result instead of outputting it.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Get the response and close the channel.
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
?>