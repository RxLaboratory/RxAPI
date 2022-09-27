<?php
    /*
        RxAPI
        
        This program is licensed under the GNU General Public License.

        Copyright (C) 2020-2022 Nicolas Dufresne and Contributors.

        This program is free software;
        you can redistribute it and/or modify it
        under the terms of the GNU General Public License
        as published by the Free Software Foundation;
        either version 3 of the License, or (at your option) any later version.

        This program is distributed in the hope that it will be useful,
        but WITHOUT ANY WARRANTY; without even the implied warranty of
        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
        See the GNU General Public License for more details.

        You should have received a copy of the *GNU General Public License* along with this program.
        If not, see http://www.gnu.org/licenses/.
    */

    $__ROOT__ = dirname(__FILE__) . "/..";
 
    require_once $__ROOT__ . '/badges/functions.php';

    if (hasArg("custom")) {
        $tok = getArg("token", "");
        if ($tok !== $apiToken) {
            badge("Unauthorized", "><", "danger");
            die();
        }

        badge(
            getArg("label"),
            getArg("value"),
            getArg("color"),
            getArg("icon"),
            hasArg("small")
        );
        die();
    }

    if (hasArg( "winstats" ))
    {
        $stats = getStats(date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))), date("Y-m-d H:i:s"));
        if ($stats) {
            badge("Windows", $stats["winRatio"] . " %", "info", "win");
            die();
        }
    }

    if (hasArg( "macstats" ))
    {
        $stats = getStats(date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))), date("Y-m-d H:i:s"));
        if ($stats) {
            badge("Mac OS", $stats["macRatio"] . " %", "info", "apple");
            die();
        }
    }

    if (hasArg( "linuxstats" ))
    {
        $stats = getStats(date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))), date("Y-m-d H:i:s"));
        if ($stats) {
            badge("Linux", $stats["linuxRatio"] . " %", "info", "linux");
            die();
        }
    }

    if ( hasArg( "dailyUsers" ) ) {

        $stats = getStats(date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))), date("Y-m-d H:i:s"));

        if ($stats) {
            $numUsers = round($stats["userCount"] / 30);
            // Add Duik 15 estimated users
            $numUsers += 8000;
            badge("Daily users", strval( $numUsers ), "info", "users");
            die();
        }
    }

    if ( hasArg( "numBackers" ) ) {

        // GET GITHUB SPONSORS
        $sponsors = ghBackers();

        // GET PATREON PATRONS
        $sponsors += patreonBackers();

        // GET STRIPE SUBSCRIPTIONS
        $sponsors += stripeSubscriptions();

        // GET WOOCOMMERCE ORDERS
        $sponsors += wcBackers();

        // CHECK ratio against daily users
        $stats = getStats(date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))), date("Y-m-d H:i:s"));
        $numUsers = $stats["userCount"] / 30 + 8000;
        $userRatio = round( $sponsors / $numUsers * 100 );

        if ($userRatio < 25) $color = "danger";
        else if ($userRatio < 50) $color = "warning";
        else if ($userRatio < 75) $color = "info";
        else $color = "ok";
        badge("Supporters", "{$sponsors} ({$userRatio} %)", $color, "users");
        die();
    }

    if ( hasArg( "monthlyIncome") ) {

        // GITHUB
        $fund = ghIncome();

        // PATREON
        $fund += patreonIncome();

        // STRIPE
        $fund += stripeIncome();

        // WOOCOMMERCE
        $fund += wcIncome();      

        if ($fundingGoal > 0) {
            $ratio = round( $fund / $fundingGoal * 100 );

            if ($ratio < 25) $color = "danger";
            else if ($ratio < 50) $color = "warning";
            else if ($ratio < 75) $color = "info";
            else $ratio = "ok";

            badge("Monthly fund", "\${$fund} ({$ratio} %)", $color, "money");
        die();
        }
    }

    if (hasArg( "version" )) {

        $tok = getArg("token", "");
        if ($tok !== $apiToken) {
            badge("Unauthorized", "><", "danger");
            die();
        }

        $prerelease = hasArg("prerelease");
        $ghUser = getArg("ghUser", $ghUser);
        $ghRepo = getArg("ghRepo");
        $label = getArg("label", $ghRepo);
        $icon = getArg("icon");

        if ($ghRepo == "") {
            badge("No tool", ":'(", "danger", null, true);
            die();
        }

        $release = ghRelease( $ghUser, $ghRepo, $prerelease );
        if (!$release) {
            badge("Unknown tool", ":'(", "neutral", null, true);
            die();
        }

        if ($prerelease) $color = "info";
        else $color = "ok";

        badge($label, $release['tagName'], $color, $icon, true);
        die();

    }

    if (hasArg( "contributors") ) {
        $tok = getArg("token", "");
        if ($tok !== $apiToken) {
            badge("Unauthorized", "><", "danger");
            die();
        }

        $ghUser = getArg("ghUser", $ghUser);
        $ghRepo = getArg("ghRepo");

        if ($ghRepo == "") {
            badge("No tool", ":'(", "danger", null, true);
            die();
        }

        $contributors = ghContributors($ghUser, $ghRepo);

        if ($contributors < 0) {
            badge("Unknown tool", ":'(", "neutral", null, true);
            die();
        }

        $color = 'neutral';
        if ($contributors < 5) $color='danger';
        else if ($contributors < 15) $color='warning';
        else if ($contributors < 30) $color='info';
        else $color='ok';

        badge("Contributors", strval($contributors), $color, 'users', true);
        die();
    }

    if (hasArg( "issuesCount") ) {
        $tok = getArg("token", "");
        if ($tok !== $apiToken) {
            badge("Unauthorized", "><", "danger");
            die();
        }

        $ghUser = getArg("ghUser", $ghUser);
        $ghRepo = getArg("ghRepo");

        if ($ghRepo == "") {
            badge("No tool", ":'(", "danger", null, true);
            die();
        }

        $issues = ghIssuesCount($ghUser, $ghRepo);

        if ($issues < 0) {
            badge("Unknown tool", ":'(", "neutral", null, true);
            die();
        }

        $color = 'neutral';
        if ($issues > 40) $color='danger';
        else if ($issues > 20) $color='warning';
        else if ($issues > 10) $color='info';
        else $color='ok';

        badge("Open tickets", strval($issues), $color, 'issue', true);
        die();
    }

    badge("Invalid request", ":'(");

?>