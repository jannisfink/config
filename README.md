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

Use it as the following
```php
use \Fink\config\Configuration;

// create a new instance
$jsonConfig = new Configuration("config.json");
$iniConfig = new Configuration("config.ini");

echo $jsonConfig->get("section", "key"); // echoes "value"
echo $iniConfig->get("section", "key");  // echoes "value", too
```

### Use custom configuration loaders

To create a new (custom) configuration loader, just create a new subclass of `\Fink\config\loader\BaseConfigurationLoader` and implement the methods needed. Be sure to override the static class member `$supportedFileTypes` as a hint for supported configuration file types.

Add the new configuration loader to the list of supported loaders:

```php
use \Fink\config\Configuration;

Configuration::addConfigurationLoader(42, YourCustomConfigurationLoader::class);

$config = new Configuration("your-custom-configuration-syntax.type", 42);
```

 Autodetect the correct loader will work for the custom one, too. If your custom loader supports a file type already supported by a predefined one, the loader with the smallest id will handle the configuration file.
