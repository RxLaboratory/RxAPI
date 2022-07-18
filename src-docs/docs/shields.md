![META](authors:Nicolas "Duduf" Dufresne;license:GNU-FDL;copyright:2022;updated:2022/07/18)

# Shields.io endpoint

You can use this endpoint to generate custom [shields.io](http://shield.io) badges. This endpoint can also be used to get some specific data.

Endpoint: `http://api.rxlab.io/shields`

## Size

![](https://img.shields.io/endpoint?url=https%3A%2F%2Fapi.rxlab.io%2Fshields%2F%3Fsize%26name%3DDuik%26asset%3D0)

You can query the size of an asset of a *Github* release; this is useful to display the size of a download for example.

### Request

- ***size***
- ***name***: the name of the script/application (of the Github repository).
- ***asset***: the asset in the latest release (an integer, `0` being the first one).

### Example

`http://api.rxlab.io/shields?size&name=Duik&asset=0`

### Reply

The reply is a JSON object which can be used with *shields.io*

#### The reply

```json
{
    "label":"size",
    "schemaVersion":1,
    "message":"4.8 MB (.zip)",
    "color":"informational",
    "isError":false
}
```

#### The *shields.io* request

`https://img.shields.io/endpoint?url=https%3A%2F%2Fapi.rxlab.io%2Fshields%2F%3Fsize%26name%3DDuik%26asset%3D0`

You can use this URL in an image tag, here's the result:

![](https://img.shields.io/endpoint?url=https%3A%2F%2Fapi.rxlab.io%2Fshields%2F%3Fsize%26name%3DDuik%26asset%3D0)

## Statistics

![](https://img.shields.io/endpoint?url=https%3A%2F%2Fapi.rxlab.io%2Fshields%2F%3Fwinstats)

![](https://img.shields.io/endpoint?url=https%3A%2F%2Fapi.rxlab.io%2Fshields%2F%3Fmacstats)

![](https://img.shields.io/endpoint?url=https%3A%2F%2Fapi.rxlab.io%2Fshields%2F%3Flinuxstats)

You can query the number of users for specific operating systems.

### Request

- ***winstats***
or
- ***macstats***
or
- ***linuxstats***

### Example

`http://api.rxlab.io/shields?winstats`

### Reply

The reply is a JSON object which can be used with *shields.io*

#### The reply

```json
{
    "label":"Win",
    "schemaVersion":1,
    "message":"77 %",
    "color":"informational",
    "isError":false,
    "namedLogo":"windows",
    "labelColor":"434343"
}
```

#### The *shields.io* request

`https://img.shields.io/endpoint?url=https%3A%2F%2Fapi.rxlab.io%2Fshields%2F%3Fwinstats`

You can use this URL in an image tag, here's the result:

![](https://img.shields.io/endpoint?url=https%3A%2F%2Fapi.rxlab.io%2Fshields%2F%3Fwinstats)

## Funding

There are three available requests to get funding information.

### Daily users

![](https://img.shields.io/endpoint?url=https%3A%2F%2Fapi.rxlab.io%2Fshields%2F%3FdailyUsers)

### Request

- ***dailyUsers***

#### Example

`http://api.rxlab.io/shields?dailyUsers`

#### Reply

The reply is a JSON object which can be used with *shields.io*

```json
{
    "label":"Daily Users",
    "schemaVersion":1,
    "message":"8148",
    "color":"informational",
    "isError":false,
    "labelColor":"434343"
}
```

`https://img.shields.io/endpoint?url=https%3A%2F%2Fapi.rxlab.io%2Fshields%2F%3FdailyUsers`

You can use this URL in an image tag, here's the result:

![](https://img.shields.io/endpoint?url=https%3A%2F%2Fapi.rxlab.io%2Fshields%2F%3FdailyUsers)

### Number of sponsors

![](https://img.shields.io/endpoint?url=https%3A%2F%2Fapi.rxlab.io%2Fshields%2F%3FnumBackers)

### Request

- ***numBackers***

#### Example

`http://api.rxlab.io/shields?numBackers`

#### Reply

The reply is a JSON object which can be used with *shields.io*

```json
{
    "label":"sponsors",
    "schemaVersion":1,
    "message":"341 (4%)",
    "color":"important",
    "isError":false,
    "labelColor":"434343"
}
```

`https://img.shields.io/endpoint?url=https%3A%2F%2Fapi.rxlab.io%2Fshields%2F%3FnumBackers`

You can use this URL in an image tag, here's the result:

![](https://img.shields.io/endpoint?url=https%3A%2F%2Fapi.rxlab.io%2Fshields%2F%3FnumBackers)

### Monthly income

![](https://img.shields.io/endpoint?url=https%3A%2F%2Fapi.rxlab.io%2Fshields%2F%3FmonthlyIncome)

### Request

- ***monthlyIncome***

#### Example

`http://api.rxlab.io/shields?monthlyIncome`

#### Reply

The reply is a JSON object which can be used with *shields.io*

```json
{
    "label":"monthly fund",
    "schemaVersion":1,
    "message":"$977 (24%)",
    "color":"important",
    "isError":false,
    "labelColor":"434343"
}
```

`https://img.shields.io/endpoint?url=https%3A%2F%2Fapi.rxlab.io%2Fshields%2F%3FmonthlyIncome`

You can use this URL in an image tag, here's the result:

![](https://img.shields.io/endpoint?url=https%3A%2F%2Fapi.rxlab.io%2Fshields%2F%3FmonthlyIncome)
