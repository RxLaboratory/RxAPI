<?php
    if ( hasArg( "numBackers") ) {
        $accepted = true;

        $reply['label'] = "sponsors";
        $reply['message'] = "none";
        $reply['isError'] = false;
        $reply['color'] = "informational";
        $reply['labelColor'] = "434343";

        // GET GITHUB SPONSORS
        $sponsors = ghBackers();

        // GET PATREON PATRONS
        $sponsors += patreonBackers();

        // GET WOOCOMMERCE ORDERS
        $sponsors += wcBackers();

        if ($sponsorsGoal > 0) {
            $ratio = $sponsors / $sponsorsGoal;
            if ($ratio < 0.25) $reply['color'] = "critical";
            if ($ratio < 0.5) $reply['color'] = "important";
            if ($ratio > 0.75) $reply['color'] = "success";
        }
        
        $reply['message'] = strval( $sponsors );

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

        // WOOCOMMERCE
        $fund += wcIncome();      

        if ($fundingGoal > 0) {
            $ratio = $fund / $fundingGoal * 100;
            $reply['message'] =  "$" . strval( (int)$fund ) . " (" .  strval((int)$ratio) . "%)";
            if ($ratio < 25) $reply['color'] = "critical";
            if ($ratio < 50) $reply['color'] = "important";
            if ($ratio > 75) $reply['color'] = "success";
        }
        else {
            $reply['message'] =  "$" . strval( (int)$fund );
        }
    }
?>