<?php
    if ( hasArg( "dailyUsers" ) ) {
        $accepted = true;

        $reply['label'] = "Daily Users";
        $reply['message'] = "none";
        $reply['isError'] = false;
        $reply['color'] = "informational";
        $reply['labelColor'] = "434343";

        $stats = getStats(date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))), date("Y-m-d H:i:s"));

        $numUsers = round($stats["userCount"] / 30);
        // Add Duik 15 estimated users
        $numUsers += 8000;

        $reply['message'] = strval( $numUsers );
    }

    if ( hasArg( "numBackers" ) ) {
        $accepted = true;

        $reply['label'] = "Supporters";
        $reply['message'] = "none";
        $reply['isError'] = false;
        $reply['color'] = "informational";
        $reply['labelColor'] = "434343";

        // GET GITHUB SPONSORS
        $sponsors = ghBackers();

        // GET PATREON PATRONS
        $sponsors += patreonBackers();

        // GET WORDPRESS MEMBERS
        $sponsors += wpBackers();

        // GET WOOCOMMERCE ORDERS
        $sponsors += wcBackers();

        // CHECK ratio against daily users
        $stats = getStats(date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))), date("Y-m-d H:i:s"));
        $numUsers = $stats["userCount"] / 30 + 8000;
        $userRatio = round( $sponsors / $numUsers * 100 );

        if ($userRatio < 25) $reply['color'] = "critical";
        if ($userRatio < 50) $reply['color'] = "important";
        if ($userRatio > 75) $reply['color'] = "success";
        
        $reply['message'] = $sponsors . " (" . $userRatio . " %)";
    }

    if ( hasArg( "monthlyIncome") ) {
        $accepted = true;

        $reply['label'] = "monthly fund";
        $reply['message'] = "none";
        $reply['isError'] = false;
        $reply['color'] = "informational";
        $reply['labelColor'] = "434343";

       // GITHUB
       $fund = ghIncome();

        // PATREON
        $fund += patreonIncome();

        // WORDPRESS
        $fund += wpIncome();

        // WOOCOMMERCE
        $fund += wcIncome();      

        if ($fundingGoal > 0) {
            $ratio = $fund / $fundingGoal * 100;
            $reply['message'] =  "$" . strval( (int)$fund ) . " (" .  strval((int)$ratio) . " %)";
            if ($ratio < 25) $reply['color'] = "critical";
            if ($ratio < 50) $reply['color'] = "important";
            if ($ratio > 75) $reply['color'] = "success";
        }
        else {
            $reply['message'] =  "$" . strval( (int)$fund );
        }
    }
?>