![META](authors:Nicolas "Duduf" Dufresne;license:GNU-FDL;copyright:2022;updated:2022/07/18)

# Quote endpoint

*RxAPI* serves random quotes.

Just call the endpoint: `http://api.rxlab.io` and the server replies with a JSON object containing the quote and its author.

## Example

Request:

`http://api.rxlab.io/quote`

Reply:

```json
{
    "quote":"The fate of the country does not depend on how you vote at the polls \u2014 the worst man is as strong as the best at that game; it does not depend on what kind of paper you drop into the ballot-box once a year, but on what kind of man you drop from your chamber into the street every morning.",
    "author":"Henry David Thoreau"
}
```

The list of the quotes is stored on the server side, as a JSON file: `/quote/quotes.json`.