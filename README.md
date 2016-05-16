# A simple yet powerful configuration library for PHP

[![Build Status](https://travis-ci.org/jannisfink/config.svg?branch=master)](https://travis-ci.org/jannisfink/config) [![Coverage Status](https://coveralls.io/repos/github/jannisfink/config/badge.svg?branch=master)](https://coveralls.io/github/jannisfink/config?branch=master)

[![Latest Stable Version](https://poser.pugx.org/fink/config/v/stable)](https://packagist.org/packages/fink/config) [![Latest Unstable Version](https://poser.pugx.org/fink/config/v/unstable)](https://packagist.org/packages/fink/config) [![License](https://poser.pugx.org/fink/config/license)](https://packagist.org/packages/fink/config)

## Usage

Given this configuration file in json format:

```json
{
  "section": {
    "key": "value"
  }
}
```

Use the configuration class like the following:

```php
use \Fink\config\Configuration;

// create a new instance
$config = new Configuration("config.json", Configuration::JSON);

// access a specific value
echo $config->get("section", "key"); // echoes "value"
```

## Features

### Multiple configuration formats

The library currently supports json and ini format. If you want an additional format, open a new issue or pull request.

### Auto detection of configuration format

The second parameter of the class Configuration is optional. So this is equal:

config.ini
```ini
[section]
key = value
```

config.json
```json
{
  "section": {
    "key": "value"
  }
}
```

Use it as following
```php
use \Fink\config\Configuration;

// create a new instance
$jsonConfig = new Configuration("config.json");
$iniConfig = new Configuration("config.ini");

echo $jsonConfig->get("section", "key"); // echoes "value"
echo $iniConfig->get("section", "key");  // echoes "value", too
```
