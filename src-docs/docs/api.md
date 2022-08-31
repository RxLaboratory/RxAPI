![META](authors:Nicolas "Duduf" Dufresne;license:GNU-FDL;copyright:2022;updated:2022/07/18)

# API reference

## Introduction

*RxAPI* is able to serve **update and funding information** about any tool you're developing/maintaining/releasing. When a script or application checks if an update is available, *RxAPI* stores some anonymous information and is able to serve some usage statistics. This data can not be used to identify or track individual users in any way; there's no fingerprinting possible.

### Update info

The update information is pulled from **github repositories**, using the *release* features. We may add support for *Gitlab* later.

### Funding info

*RxAPI* also collects funding information from various sources, to summarize all the funds and supporters got by the organization. These are the current sources (we may add more later):

- **Github Sponsors**
- WordPress: **WooCommerce**
- **Stripe subscriptions**
- **Patreon**

### Statistics

For each request from a script or application, *RxAPI* stores the following information, if it is provided by the script or application:

- Script / Application **name and version**
- **OS** and OS version
- **Host application** and its version (if any)
- **Language code**
- The **date** of the request

We may add geographical data later (such as the country).

This data can be retrieved by a request to the API.

Script and application should check for update once a day and not more: that's a reliable way to estimate the number of daily users.

### Shields

*RxAPI* provides a specific endpoint to be used with [shields.io](http://shields.io). Read [more details here](shields.md).

### Quote

*RxAPI* provides a special endpoint to get random quotes. Read [more details here](quote.md).

## Usage

For the following documentation, we're using our official *RxLab* server instance as an example. It is located at `http://api.rxlab.io`.

### Update and funding information

Endpoint: `http://api.rxlab.io`

#### Request

- ***getVersion***
- ***name***: the name of the script / application checking for update. This should be the name of the corresponding *Github* repository, unless an alias has been setup on the server side.
- ***version***: the version of the script / application, a string using [semantic versionning](https://semver.org/) in the form `M.m.p`, e.g. `1.2.0`.
- ***os*** (optional): the operating system. It should be one of *win*, *mac*, *linux*, *android* or *ios*.
- ***osVersion*** (optional): the version of the operating system, using semantic versionning (e.g. *10.0*, *12.5*, etc).
- ***host*** (optional): the host application (e.g. *photoshop*, *blender*, *aftereffects*, *maya*, etc.).
- ***hostVersion*** (optional): the version of the host application.
- ***languageCode*** (optional): the code for the current locale of the script / application (e.g. "en", "es", "fr"...)
- ***prerelease*** (optionnal). Add this argument to check for PreRealease versions instead of Released versions, according to the *Github* release option.

#### Examples

- `http://api.rxlab.io?getVersion&name=Ramses-Client&version=0.2.9&os=linux&osVersion=Ubuntu 20.04&prerelease`

- `http://api.rxlab.io?getVersion&name=Duik&version=16.2.30&os=win&osVersion=11.0&host=aftereffects&hostVersion=22.6`

#### Reply

*RxAPI* replies with a JSON object.

```json
{
    "accepted":true,
    "success":true,
    "message":"Successful request.",
    "update":false,
    "name":"Duik",
    "donateURL":"http:\/\/donate.rxlab.info",
    "downloadURL":"https:\/\/rxlaboratory.org",
    "changelogURL":"https:\/\/rxlaboratory.org",
    "version":"16.2.30",
    "newName":"Duik Bassel.2 Update 30",
    "description":"The thirtieth update of Duik Bassel.2 fixes some auto-rig issues due to changes in the scripting API in After Effects 2021.\r\n\r\nAs always, it is strongly advised to update Duik as soon as you can.\r\n\r\nThe detailed list of what\u2019s new is available in the changelog [here](https:\/\/duik.rxlab.guide\/duik-16-changelog.html).\r\n\r\nHere is the [comprehensive documentation for Duik](https:\/\/duik.rxlab.guide), and here is the [reference for the Duik API](https:\/\/duik.rxlab.io\/).",
    "date":"2021-07-28T17:41:59Z",
    "monthlyFund":973.41,
    "fundingGoal":4000
}
```

If `update` is true, that means the script/application has a new update available.

### Statistics

Endpoint: `http://api.rxlab.io`

#### Request

- ***getStats***
- ***from*** (optional): the date from which to get the statistics. By default, 30 days before the current date. A string in the form `YYYY-MM-DD`.
- ***to*** (optional): the date to which to get the statistics. By default, today. A string in the form `YYYY-MM-DD`.

#### Examples

- `http://api.rxlab.io?getStats`
- `http://api.rxlab.io?getStats&from=2022-07-01`

#### Reply

*RxAPI* replies with a JSON object, including an array of objects representing the scripts/applications for which it has some statistics.

```json
{
    "accepted":true,
    "success":true,
    "message":"",
    "winCount":3391,
    "winRatio":77,
    "macCount":1034,
    "macRatio":23,
    "linuxCount":6,
    "linuxRatio":0,
    "userCount":4431,
    "apps":[
        {"name":"Duik","count":1996,"ratio":45,"host":"aftereffects"},
        {"name":"DuGR","count":1732,"ratio":39,"host":"after-effects"},
        {"name":"Ramses-Client","count":429,"ratio":10,"host":""},
        {"name":"DuSan","count":235,"ratio":5,"host":"aftereffects"},
        {"name":"DuBlast","count":37,"ratio":1,"host":"Blender"},
        {"name":"DuFlatnr","count":2,"ratio":0,"host":"photoshop"}
    ],
    "languages": [
        {"name":"English","code":"en","count":800,"ratio":80},
        {"name":"Français","code":"fr","count":200,"ratio":20}
    ],
    "countries": [
        {"name":"US","count":800,"ratio":80},
        {"name":"FR","count":200,"ratio":20}
    ]
}
```

- `winCount`, `macCount`, `linuxCount` are the number of users for each OS. To get the number of daily users, divide it by the number of days included in the statistics (30 by default).
- `winRatio`, `macRatio`, `linuxRatio` are the ratios in percent.
- `userCount` is the total number of users. To get the number of daily users, divide it by the number of days included in the statistics (30 by default).
- For each app, `count` is the number of requests, `ratio` is the ratio between this count and the total number of requests, in percent.