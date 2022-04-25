# RxAPI
RxLaboratory API : Public REST API to check for updates using Github releases, and retrieve general information about the organisation current status (funding, etc).

[![PHP](https://img.shields.io/badge/Web-PHP-informational?color=lightgrey&logo=php)](#) [![GitHub](https://img.shields.io/github/license/RxLaboratory/Duik?color=lightgrey)](LICENSE.md)

**Status:**  
[![GitHub release (latest SemVer)](https://img.shields.io/github/v/release/RxLaboratory/RxVersion?color=brightgreen)](https://github.com/RxLaboratory/RxVersion/releases) [![GitHub Release Date](https://img.shields.io/github/release-date/RxLaboratory/RxVersion)](https://github.com/RxLaboratory/RxVersion/releases) [![GitHub tag (latest SemVer pre-release)](https://img.shields.io/github/v/tag/RxLaboratory/RxVersion?include_prereleases&label=testing)](https://github.com/RxLaboratory/RxVersion/tags)

**Documentation:**  
[![Website](https://img.shields.io/badge/website-RxLab-informational)](http://rxlaboratory.org)

**Statistics:**  
[![GitHub all releases](https://img.shields.io/github/downloads/RxLaboratory/RxVersion/total)](https://github.com/RxLaboratory/RxVersion/releases) [![GitHub release (latest by SemVer)](https://img.shields.io/github/downloads/RxLaboratory/RxVersion/latest/total?sort=semver)](https://github.com/RxLaboratory/RxVersion/releases) [![GitHub issues](https://img.shields.io/github/issues-raw/RxLaboratory/RxVersion)](https://github.com/RxLaboratory/RxVersion/issues) [![GitHub closed issues](https://img.shields.io/github/issues-closed-raw/RxLaboratory/RxVersion?color=lightgrey)](https://github.com/RxLaboratory/RxVersion/issues?q=is%3Aissue+is%3Aclosed) [![GitHub commit activity](https://img.shields.io/github/commit-activity/m/RxLaboratory/RxVersion)](https://github.com/RxLaboratory/RxVersion/graphs/commit-activity)  
(Download count from 15 April 2022)

**Funding:**  
[![Donate Now!](https://img.shields.io/badge/donate%20now!-donate.rxlab.info-blue?logo=heart)](http://donate.rxlab.info) [![Income](https://img.shields.io/endpoint?url=https%3A%2F%2Fversion.rxlab.io%2Fshields%2F%3FmonthlyIncome)](http://donate.rxlab.info) [![Sponsors](https://img.shields.io/endpoint?url=https%3A%2F%2Fversion.rxlab.io%2Fshields%2F%3FnumBackers)](http://donate.rxlab.info)  
(includes sponsors from [Github](https://github.com/sponsors/RxLaboratory) and [Patreon](https://patreon.com/duduf))

**Community:**  
[![Discord](https://img.shields.io/discord/480782642825134100)](http://chat.rxlab.info) [![Contributor Covenant](https://img.shields.io/badge/Contributor%20Covenant-2.1-4baaaa.svg)](CODE_OF_CONDUCT.md) ![GitHub contributors](https://img.shields.io/github/contributors-anon/RxLaboratory/Duik)  
[![Discord](https://img.shields.io/discord/480782642825134100?logo=discord&style=social&label=Discord)](http://chat.rxlab.info)
[![Facebook](https://img.shields.io/badge/Facebook-1877F2?logo=facebook&style=social)](https://www.facebook.com/rxlaboratory) [![Instagram](https://img.shields.io/badge/Instagram-E4405F?logo=instagram&style=social)](https://www.instagram.com/rxlaboratory/) [![Twitter Follow](https://img.shields.io/twitter/follow/RxLaboratory?label=Twitter&style=social)](https://www.twitter.com/rxlaboratory/) [![LinkedIn](https://img.shields.io/badge/LinkedIn-0077B5?logo=linkedin&style=social)](https://www.linkedin.com/company/RxLaboratory/) [![YouTube Channel Views](https://img.shields.io/youtube/channel/views/UC64qGypBbyM-ia-yf0nFSTg?label=Youtube)](https://www.youtube.com/channel/UC64qGypBbyM-ia-yf0nFSTg) [![Github](https://img.shields.io/badge/GitHub-100000?logo=github&logoColor=100000&style=social)](https://github.com/RxLaboratory/Duik)

Make it light, easy and simple.

This is a very simple PHP+SQL server to allow scripts, add-ons, applications, etc. to check for updates.  
It checks the Github releases of the corresponding repo to see if newer versions are available (using semantic versioning).

## Features

- Check for releases or pre-releases.
- Fetches release info: description, name, date, size...
- Shows funding status and goals:
    - Retrieves *Github Sponsors*
    - Retrieves Patrons from *Patreon*
    - Retrieves Membership through Wordpress *Paid Memberships Pro* plugin.
    - Retrieves Products sold through *WooCommerce*
- Endpoints for use with [shields.io](https://shields.io)
- Keeps anonymous statistics: number of version checks, OS, version of the OS, etc.

The software which needs to check for update just have to use a *GET* query, providing its own name and version; the server replies with the update information, a download link, etc.

This server communicates with other API via HTTPS, but the public API can post through HTTP to make it availabe to Adobe ExtendScript.

## Example

### Query

`http://your.server/rxversion/?getVersion&name=Duik&version=17.0.0`

- ***getVersion***: This arg is needed to get a version
- ***name*** {string}: The name of the software. Should be the name of the corresponding Github Repo.
- ***version*** {string}: The current version.
- ***prerelease***: Add this parameter to include prereleases to the check.

### Reply

The server replies with a *JSON* object looking like this:

```json
{
    "update": true,
    "version": "17.1.0",
    "downloadURL": "https://rainboxlab.org/tools/duik",
    "changelogURL": "http://duik.rxlab.guide/duik-16-changelog.html",
    "donateURL": "http://donate.rxlab.info",
    "name": "Duik",
    "newName": "Duik Ángela.1",
    "description": "This updates has a lot of bugfixes.",
    "date": "2021-07-29T11:25:03Z",
    "message": "Successful request.",
    "monthlyFund": 1134,
    "fundingGoal": 4000,
    "success": true,
    "accepted": true
}
```

- ***update*** will be false if this is not a new version.
- ***message*** explains any potential error.
- ***success*** is false if anything went wrong
- ***accepted*** is false if the query is incorrect (malformed, missing arg, etc.)

## Installation

Edit the `config.php` file, upload the files to the server then go to the `install` folder with a browser.

Remove the `install` folder once the setup has completed, et voilà !
