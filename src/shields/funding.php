<?php
    if ( hasArg( "numBackers") ) {
        $accepted = true;

        // GET GITHUB SPONSORS

        $reply['label'] = "sponsors";
        $reply['message'] = "none";
        $reply['isError'] = false;
        $reply['color'] = "informational";
        $reply['labelColor'] = "434343";

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
        $sponsors = $gh["data"]["organization"]["sponsors"]["totalCount"];

        // GET PATREON PATRONS

        // Add Patreon count
        if ($patreonToken != "") {
            $patreon = patreonRequest("https://www.patreon.com/api/oauth2/api/current_user/campaigns");
            $patreon = json_decode($patreon, true);
            $sponsors += $patreon["data"][0]["attributes"]["patron_count"];
        };

        // GET WOOCOMMERCE ORDERS
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

            $sponsors += $wcCount;
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
        $fund /= 100;

        // Add Patreon count
        if ($patreonToken != "") {
            $patreon = patreonRequest("https://www.patreon.com/api/oauth2/api/current_user/campaigns");
            $patreon = json_decode($patreon, true);
            $fund += $patreon["data"][0]["attributes"]["pledge_sum"] / 100;
        };

        // GET WOOCOMMERCE ORDERS
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

            $fund += $wcCount;
        }

        if ($fundingGoal > 0) {
            $ratio = $fund / $fundingGoal * 100;
            $reply['message'] =  "$" . strval( (int)$fund ) . " (" .  strval((int)$ratio) . "%)";
        }
        else {
            $reply['message'] =  "$" . strval( (int)$fund );
        }
    }
?>