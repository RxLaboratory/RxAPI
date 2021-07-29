# RxVersion
 Rx Version Server : REST API to check for updates

Make it light, easy and simple.

This is a very simple PHP+SQL server to allow scripts, add-ons, applications, etc. to check for updates.

The info is stored in an SQL server; the server does provide any way to set the update information yet, one has to manually populate the SQL database using tools like phpMyAdmin.

The software which needs to check for update just have to use a *GET* query, providing its own name and version; the server replies with the update information, a download link, etc.

## Example

### Query

`http://your.server/rxversion/?getVersion&name=Duik&version=17.0.0&os=win&osVersion=10&host=After Effects 2021&hostVersion=18.4`

- ***getUpdate***: This arg is needed to get a version
- ***name***: The name of the software
- ***version***: the current version
- ***os***, *optional*: one of `win`, `mac`, `ios`, `android`, `linux`,`any` (or `all`). If omitted, same as `any` or `all`. Any other value will be considered to be the name of a linux distribution, thus being linux too.
- ***osVersion***, *optional*: any string identifying the version of the OS (could be a name like `Maverick` or `Focal Fossa` or a version like `10.15.2` or `20.04`, etc.)
- ***host***, *optional*: the name of a host application, in case this is an add-on or something which depends on another app? May be `any` or (`all`). If omitted, same as `any` or `all`.
- ***hostVersion***, *optional*: the version of the host application, could be any string.

Note that the server won't match the `osVersion` and `hostVersion` to check for updates. Only the `name`, `version`, `os` and `host` are used, all other information is used only for usage statistics.

### Reply

The server replies with a *JSON* object looking like this:

```json
{
    "update": true,
    "version": "17.1.0",
    "name": "Duik",
    "description": "This updates has a lot of bugfixes.",
    "downloadURL": "https://rainboxlab.org/tools/duik",
    "changelogURL": "http://duik.rxlab.guide/duik-16-changelog.html",
    "donateURL": "http://donate.rxlab.info",
    "date": "2021-07-29 11:25:03",
    "message": "Successful request.",
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
