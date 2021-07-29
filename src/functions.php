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
            $reply["message"] = "Invalid request, missing values";
            $reply["success"] = false;
        }
        return $ok;
    }

    function sqlRequest( $request, $message, $debug = false )
    {
        global $reply;

        if ($debug) $request->debugDumpParams();

        $ok = $request->execute();

        if (!$ok)
        {
            $reply["message"] = $rep->errorInfo()[2];
            $reply["success"] = false;
        }
        else if ($message != "")
        {
            $reply["message"] = $message;
            $reply["success"] = true;
        }
        
        return $ok;
    }

    function acceptReply($queryName)
    {
        global $reply;
        $reply["accepted"] = true;
		$reply["query"] = $queryName;
    }
?>