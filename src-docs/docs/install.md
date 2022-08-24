![META](authors:Nicolas "Duduf" Dufresne;license:GNU-FDL;copyright:2022;updated:2022/07/18)

# Installation guide

## Prerequisites

RxAPI must be installed on a computer with:

- An http web server like Apache
- PHP 7 or more recent
- An acces to a mySQL/MariaDB server and a dedicated database.

The recommended configuration is a standard AMP stack (Apache - mySQL - PHP). That's easy to install on any computer, and it should be available with most of web hosting providers, even the cheapest shared hostings.

## Install

1. **Create a database** and add a corresponding **user** to your SQL database.

1. **Download** the server from the [repository](https://github.com/RxLaboratory/RxAPI/releases).

1. **Set up the config file** with needed information (read below for more details).

1. **Upload** the content of the `src` directory to your server.

1. Go to the install URL: `http://yourserver.tld/rxapi/install` for example. The correct URL depends on your host and domain name.

## Use

Most of the data should be automatically served from your *Github* repos.

To check for updates, *RxAPI* will look for the tags in the corresponding *Github* repo to compare the current version with the latest tag. This means the tags and the script/application checking for udpate must use [semantic versionning](https://semver.org/).

To find the correct repository, *RxAPI* will use the user set in the config file, and the name of the script or application checking for update. To override this information for a specific script or application (set an alias to the *Github* repo), you can manually add the information directly in the `rxv_apps` table of the SQL database.

## Config file

Here's the default config file, comments should help you understand what you need to add.

```php
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

    // Edit this configuration file before running the install script at /install/index.php

	// === DEV MODE ===
	// Activates printing the SQL & PHP errors.
	// For security reasons, it is important to set this to false in production mode
	$devMode = false;

	// ==== SQL SETTINGS ====

	// Host URL
	$sqlHost = "localhost";
	$sqlPort = 3306;
	// Database name
	$sqlDBName = "rxversion";
	// User
	$sqlUser = "rxversion";
	// Password
	$sqlpassword = "eEGWRk7i";
	// Table prefix
	// DO NOT CHANGE THIS, not working yet
	$tablePrefix = "rxv";

	// ==== General Settings ====
	// Main associated website
	$orgURL = 'https://rxlaboratory.org';
	// How long to cache results to improve perfs (seconds, default is 300)
	$cacheTimeout = 300;

	// ==== Funding ====
	$fundingGoal = 4000;
	$donateURL = 'http://donate.rxlab.info';

	// ==== Github Settings ====
	$ghUsername = "YourPersonalUserName";
	$ghToken = "YourPersonalAccessToken";
	$ghUser = "RxLaboratory";

	// ==== Patreon Settings ====
	// Leave empty if you don't use Patreon
	// Otherwise, create an application on Patreon
	// And add the Creator's access token here
	$patreonToken = "";

	// ==== Stripe Settings ====
	// Leave empty if you don't use Stripe
	// Otherwise, get a Strip API Key,
	// And add it here
	$stripeKey = "";

	// ==== WooCommerce Settings ====
	// Leave empty if you don't use WooCommerce
	// Otherwise create an API Key on WooCommerce
	// The client key
	$wcUsername = "";
	// The client secret
	$wcToken = "";
	// List the products to check, leave empty for all. Must be the product ids.
	$wcProducts = array();

	// ==== Discord Settings ====
	// Leave empty if you don't use Discord
	// The token for your discord bot
	$discordBotToken = "";
?>
```