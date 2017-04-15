# Open Api (2.0) common definitions.
This repo contains a subset of [openapi](https://www.openapis.org/) definition files, written in Yaml.
To scripts to get to generate these files are located in the scripts directory. Just use ['$ref'](https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#fixed-fields-4) like this:

```yaml
currency:
    $ref: "https://raw.githubusercontent.com/iain17/common-openapi/master/currency.yml?#/currency"
```

## Scripts
Written in PHP because its very easy to prototype in and make quick little scripts like this. Also developers are likely to know some PHP. Run a generation script like so from the command line:
```bash
cd currency;
php generate.php
```

## Definition files

The defintion files are used to map the short codes to a descriptive name. This can be used in the GUI of your application.

## Why

I made this repo because I couldn't find an existing one doing this. Using this yml files in the root of this project I can quickly reference all the possible countries or currencies.