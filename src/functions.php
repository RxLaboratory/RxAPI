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

    // === CACHE ===
    function getCache( $name ) {
        global $cacheTimeout;

        // Create the cache folder
        if (!is_dir("cache")) mkdir("cache", 0744);

        // Get file if it exists and is young enough
        $cacheFile = "cache/" . $name;

        if (file_exists($cacheFile) && time() - $cacheTimeout < filemtime($cacheFile)) {
            $cached = fopen($cacheFile, 'r');
            $content = "";
            if ($cached !== false) {
                $content = fread($cached, filesize($cacheFile));
                fclose($cached);
            }
            return $content;
        }

        return "";
    }

    function saveCache( $name, $content ) {
        // Create the cache folder
        if (!is_dir("cache")) mkdir("cache", 0744);

        // Get file
        $cacheFile = "cache/" . $name;

        // Cache the contents to a cache file
        $cached = fopen($cacheFile, 'w');
        if ($cached !== false) {
            fwrite($cached, $content);
            fclose($cached);
        }
    }

    // === GITHUB ===

    function ghRequest( $url ) {
        global $ghUsername;
        global $ghToken;

        $userAgent = 'RxAPI/2.0 (PHP)';

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

        $userAgent = 'RxAPI/2.0 (PHP)';

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

        $cached = getCache( "ghBackers" );
        if ($cached != "") return (int)$cached;

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

        $count = $gh["data"]["organization"]["sponsors"]["totalCount"];

        saveCache("ghBackers", $count);

        return $count;
    }

    function ghIncome() {
        $cached = getCache( "ghIncome" );
        if ($cached != "") return (float)$cached;

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
        $fund = $gh["data"]["organization"]["monthlyEstimatedSponsorsIncomeInCents"] / 100;

        saveCache("ghIncome", $fund);

        return $fund;
    }

    // === PATREON ===

    function patreonRequest( $url ) {
        global $patreonToken;

        $userAgent = 'RxAPI/2.0 (PHP)';
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
        $cached = getCache( "patreonBackers" );
        if ($cached != "") return (int)$cached;

        global $patreonToken;
        // Add Patreon count
        if ($patreonToken != "") {
            $patreon = patreonRequest("https://www.patreon.com/api/oauth2/api/current_user/campaigns");
            $patreon = json_decode($patreon, true);

            $count = $patreon["data"][0]["attributes"]["patron_count"];
            saveCache("patreonBackers", $count);

            return $count;
        };
        return 0;
    }

    function patreonIncome() {
        $cached = getCache( "patreonIncome" );
        if ($cached != "") return (float)$cached;

        global $patreonToken;
        // Add Patreon count
        if ($patreonToken != "") {
            $patreon = patreonRequest("https://www.patreon.com/api/oauth2/api/current_user/campaigns");
            $patreon = json_decode($patreon, true);
            $fund = $patreon["data"][0]["attributes"]["pledge_sum"] / 100;
            saveCache("patreonIncome", $fund);
            return $fund;
        };
        return 0;
    }

    // === WORDPRESS MEMBERSHIP ===
    function wpRequest( $url ) {
        global $wpUsername;
        global $wpPassword;

        $userAgent = 'RxAPI/2.0 (PHP)';

        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_USERAGENT, $userAgent );
        curl_setopt($ch, CURLOPT_USERPWD, "{$wpUsername}:{$wpPassword}");
        curl_setopt($ch, CURLOPT_URL, $url);
        // Set so curl_exec returns the result instead of outputting it.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Get the response and close the channel.
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    function wpBackers() {
        $cached = getCache( "wpBackers" );
        if ($cached != "") return (int)$cached;

        global $wpUsername;
        global $wpPassword;

        if ($wpUsername == "" || $wpPassword == "") return 0;

        $count = 0;

        $members = wpRequest("https://rxlaboratory.org/wp-json/wp/v2/users?roles=subscriber,customer");
        $members = json_decode($members, true);

        // For each member, check the membership
        foreach( $members as $member ) {
            $id = $member['id'];
            $level = wpRequest("https://rxlaboratory.org/wp-json/pmpro/v1/get_membership_level_for_user?user_id={$id}");
            $level = json_decode($level, true);
            if ($level) {
                $enddate = (int)$level["enddate"];
                if ( $enddate == 0 || $enddate > time() ) $count++;
            }
        }

        saveCache("wpBackers", $count);
        return $count;
    }

    function wpIncome() {
        $cached = getCache( "wpIncome" );
        if ($cached != "") return (float)$cached;

        global $wpUsername;
        global $wpPassword;

        if ($wpUsername == "" || $wpPassword == "") return 0;

        $fund = 0;

        $members = wpRequest("https://rxlaboratory.org/wp-json/wp/v2/users?roles=subscriber,customer");
        $members = json_decode($members, true);

        // For each member, check the membership
        foreach( $members as $member ) {
            $id = $member['id'];
            $level = wpRequest("https://rxlaboratory.org/wp-json/pmpro/v1/get_membership_level_for_user?user_id={$id}");
            
            $level = json_decode($level, true);
            if ($level) {
                $enddate = (int)$level["enddate"];
                if ( $enddate > 0 && $enddate < time() ) continue;

                $amount = (float)$level["billing_amount"];
                $cycle_num = (int)$level["cycle_number"];
                $cycle_period = $level["cycle_period"];
                if ($cycle_num == 0) continue;

                if ($cycle_period == "Day") {
                    $amount = (30 / $cycle_num) * $amount;
                }
                else if ($cycle_period == "Week") {
                    $amount = (4 / $cycle_num) * $amount;
                }
                else if ($cycle_period == "Month") {
                    $amount = $amount / $cycle_num;
                }
                else if ($cycle_period == "Year") {
                    $amount = $amount / (12 * $cycle_num);
                }

                $fund += $amount;
            }
        }
        saveCache("wpIncome", $fund);
        return $fund;
    }

    // === WOOCOMMERCE ===

    function wcRequest( $url ) {
        global $wcUsername;
        global $wcToken;
        global $wcProducts;

        $userAgent = 'RxAPI/2.0 (PHP)';

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
        $cached = getCache( "wcBackers" );
        if ($cached != "") return (int)$cached;

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

            saveCache("wcBackers", $wcCount);
            return $wcCount;
        }
        return 0;
    }

    function wcIncome() {
        $cached = getCache( "wcIncome" );
        if ($cached != "") return (float)$cached;

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
            if (gettype($wc) == 'array')
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

            saveCache("wcIncome", $wcCount);
            return $wcCount;
        }
        return 0;
    }
    
?>