# RxVersion
Rx Version Server : REST API to check for updates using Github releases

Make it light, easy and simple.

This is a very simple PHP+SQL server to allow scripts, add-ons, applications, etc. to check for updates.  
It checks the Github releases of the corresponding repo to see if newer versions are available (using semantic versioning).

## Features

- Check for releases or pre-releases.
- Fetches release info: description, name, date...
- Shows funding status and goals:
    - Retrieves Github Sponsors
    - Retrieves Patrons from Patreon
    - Retrieves Products sold through WooCommerce
- Endpoints for use with [shields.io](https://shields.io)
- Keeps anonymous statistics: number of version checks, OS, version of the OS, etc.

The software which needs to check for update just have to use a *GET* query, providing its own name and version; the server replies with the update information, a download link, etc.

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
