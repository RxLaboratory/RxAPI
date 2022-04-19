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

    // === GITHUB ===

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

    function ghGraphQL( $query ) {
        global $ghUsername;
        global $ghToken;

        $userAgent = 'RxVersions/2.0 (PHP)';

        $ch = curl_init( "https://api.github.com/graphql" );
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array(
                "User-Agent: {$userAgent}",
                "Content-Type: application/json;charset=utf-8",
                "Authorization: bearer {$ghToken}"
            )
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    function ghBackers() {
        global $ghUser;

        $query = <<<JSON
        query {
            organization(login: "$ghUser") {
                sponsors {
                    totalCount
                }
            }
        }
        JSON;
        $variables = '';

        $query = json_encode(['query' => $query, 'variables' => $variables]);

        $gh = ghGraphQL($query);
        $gh = json_decode($gh, true);
        return $gh["data"]["organization"]["sponsors"]["totalCount"];
    }

    function ghIncome() {
        global $ghUser;

        $query = <<<JSON
        query {
            organization(login: "$ghUser") {
                monthlyEstimatedSponsorsIncomeInCents
            }
        }
        JSON;
        $variables = '';

        $query = json_encode(['query' => $query, 'variables' => $variables]);

        $gh = ghGraphQL($query);
        $gh = json_decode($gh, true);
        $fund = $gh["data"]["organization"]["monthlyEstimatedSponsorsIncomeInCents"];
        return $fund / 100;
    }

    // === PATREON ===

    function patreonRequest( $url ) {
        global $patreonToken;

        $userAgent = 'RxVersions/2.0 (PHP)';
        $ch = curl_init( $url );
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array(
                "User-Agent: {$userAgent}",
                "Content-Type: application/json;charset=utf-8",
                "Authorization: bearer {$patreonToken}"
            )
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    function patreonBackers() {
        global $patreonToken;
        // Add Patreon count
        if ($patreonToken != "") {
            $patreon = patreonRequest("https://www.patreon.com/api/oauth2/api/current_user/campaigns");
            $patreon = json_decode($patreon, true);
            return $patreon["data"][0]["attributes"]["patron_count"];
        };
        return 0;
    }

    function patreonIncome() {
        global $patreonToken;
        // Add Patreon count
        if ($patreonToken != "") {
            $patreon = patreonRequest("https://www.patreon.com/api/oauth2/api/current_user/campaigns");
            $patreon = json_decode($patreon, true);
            return $patreon["data"][0]["attributes"]["pledge_sum"] / 100;
        };
        return 0;
    }

    // === WOOCOMMERCE ===

    function wcRequest( $url ) {
        global $wcUsername;
        global $wcToken;
        global $wcProducts;

        $userAgent = 'RxVersions/2.0 (PHP)';

        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_USERAGENT, $userAgent );
        curl_setopt($ch, CURLOPT_USERPWD, "{$wcUsername}:{$wcToken}");
        curl_setopt($ch, CURLOPT_URL, $url);
        // Set so curl_exec returns the result instead of outputting it.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Get the response and close the channel.
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    function wcBackers() {
        global $wcToken;
        global $wcUsername;
        global $wcProducts;
        if ($wcToken != "" && $wcUsername != "") {
            // Get current month
            $d = new DateTime('first day of this month');
            $d = urlencode( $d->format('Y-m-d\TH:i:s') );
            $wc = wcRequest( "https://rxlaboratory.org/wp-json/wc/v3/orders?after={$d}&per_page=100" );
            $wc = json_decode($wc, true);
            $wcCount = 0;
            foreach ($wc as $order) {
                // Check the product
                if (count($wcProducts) > 0) {
                    foreach( $order["line_items"] as $item ) {
                        if($order["status"] != "processing" && $order["status"] != "completed" ) continue;
                        if (in_array($item["product_id"], $wcProducts)) {
                            $wcCount++;
                            break;
                        }
                    }
                }
                // add whole order
                else {
                    $wcCount++;
                }
            }

            return $wcCount;
        }
        return 0;
    }

    function wcIncome() {
        global $wcToken;
        global $wcUsername;
        global $wcProducts;
        if ($wcToken != "" && $wcUsername != "") {
            // Get current month
            $d = new DateTime('first day of this month');
            $d = urlencode( $d->format('Y-m-d\TH:i:s') );
            $wc = wcRequest( "https://rxlaboratory.org/wp-json/wc/v3/orders?after={$d}&per_page=100" );
            $wc = json_decode($wc, true);
            $wcCount = 0;
            foreach ($wc as $order) {
                if($order["status"] != "processing" && $order["status"] != "completed" ) continue;
                // Check the product
                if (count($wcProducts) > 0) {
                    foreach( $order["line_items"] as $item ) {
                        if (in_array($item["product_id"], $wcProducts)) {
                            $wcCount += (int)$item["subtotal"];
                            break;
                        }
                    }
                }
                // add whole order
                else {
                    $wcCount += $wc["total"];
                }
            }

            return $wcCount;
        }
        return 0;
    }
    
?>