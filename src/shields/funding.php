<?php
    if ( hasArg( "numBackers") ) {
        $accepted = true;

        $reply['label'] = "sponsors";
        $reply['message'] = "none";
        $reply['isError'] = false;
        $reply['color'] = "informational";

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

        // Add Patreon count
        if ($patreonToken != "") {
            $patreon = patreonRequest("https://www.patreon.com/api/oauth2/api/current_user/campaigns");
            $patreon = json_decode($patreon, true);
            $sponsors += $patreon["data"][0]["attributes"]["patron_count"];
        };

        $reply['message'] = strval( $sponsors );
    }

    if ( hasArg( "monthlyIncome") ) {
        $accepted = true;

        $reply['label'] = "development fund";
        $reply['message'] = "none";
        $reply['isError'] = false;
        $reply['color'] = "informational";

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

        $reply['message'] = strval( (int)$fund ) . "$ / month";
    }
?>