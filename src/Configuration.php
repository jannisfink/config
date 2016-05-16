<?php
// Copyright 2016 Jannis Fink
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

namespace Fink\config;

use Fink\config\loader\AutoConfigurationLoader;
use Fink\config\loader\BaseConfigurationLoader;
use Fink\config\loader\IniConfigurationLoader;
use Fink\config\loader\JsonConfigurationLoader;


/**
 * Class Configuration
 *
 * Read a configuration from file.
 *
 * @package Fink\config
 */
class Configuration {

  private static $configurationLoaders = [
    Configuration::AUTO => AutoConfigurationLoader::class,
    Configuration::INI => IniConfigurationLoader::class,
    Configuration::JSON => JsonConfigurationLoader::class
  ];

  /**
   * Constant to indicate an intelligent guess between all possible configuration formats
   */
  const AUTO = 0;

  /**
   * Constant to indicate a configuration stored in ini-format
   */
  const INI = 11;

  /**
   * Constant to indicate a configuration stored in json-format
   */
  const JSON = 22;

  private $filename;

  private $format;

  private $configurationLoaded;

  private $configuration;

  /**
   * Create a new configuration instance.
   *
   * @param string $filename the filename of the configuration file as an absolute path.
   * @param int $format format of the configuration file. Intelligent guess, if not given.
   */
  public function __construct($filename, $format = Configuration::AUTO) {
    $this->filename = $filename;
    $this->format = $format;
    $this->configurationLoaded = false;
  }

  /**
   * Read a specific key from the configuration. It will return all configuration values
   * with the type they are stored in the configuration file (int, bool, string...)
   *
   * @param array ...$path the key or keys matching a specific configuration value
   * @return mixed the value of the key given.
   *
   * @throws \Exception if the configuration key asked for could not be found
   */
  public function get(...$path) {
    if (!$this->configurationLoaded) {
      $this->loadConfiguration();
    }

    $configuration = $this->configuration;
    foreach ($path as $key) {
      if (!array_key_exists($key, $configuration)) {
        throw new \Exception($key . ' is not present in the configuration');
      }
      $configuration = $configuration[$key];
    }
    return $configuration;
  }

  private function loadConfiguration() {
    $loader = null;
    switch ($this->format) {
      case self::INI:
        $loader = new IniConfigurationLoader($this->filename);
        break;

      case self::JSON:
        $loader = new JsonConfigurationLoader($this->filename);
        break;

      case self::AUTO:
      default:
        $loader = new AutoConfigurationLoader($this->filename);
        break;
    }

    $this->configuration = $loader->parseFile();
    $this->configurationLoaded = true;
  }

  /**
   * @return array an array containing all active configuration loader with their id
   */
  public static function getConfigurationLoaders() {
    return self::$configurationLoaders;
  }

  /**
   * Add a new configuration loader to the list of supported configuration loaders
   *
   * @param int $id id of the new loader. Must be unique
   * @param BaseConfigurationLoader $loader
   *
   * @throws \Exception if there is a configuration loader present for the given id
   */
  public static function addConfigurationLoaders($id, BaseConfigurationLoader $loader) {
    if (array_key_exists($id, self::$configurationLoaders)) {
      throw new \Exception("there is already a configuration loader for id $id");
    }

    self::$configurationLoaders[$id] = $loader;
  }

}
