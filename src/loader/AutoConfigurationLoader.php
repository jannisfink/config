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

namespace Fink\config\loader;


use Fink\config\Configuration;
use Fink\config\exc\ParseException;

/**
 * Class AutoConfigurationLoader
 *
 * This class is capable of detecting the configuration format by itself and picks the
 * right configuration loader
 *
 * @package Fink\config\loader
 */
class AutoConfigurationLoader implements ConfigurationLoader {

  private static $configurationLoaders = [
    Configuration::INI => IniConfigurationLoader::class,
    Configuration::JSON => JsonConfigurationLoader::class
  ];

  private $filename;

  /**
   * ConfigurationLoader constructor.
   *
   * Create a new loader for a given file.
   *
   * @param $filename string the file name
   */
  public final function __construct($filename) {
    $this->filename = $filename;
  }

  /**
   * @return string the name of the configuration file to read
   */
  public function getFilename() {
    return $this->filename;
  }

  /**
   * Parse a given configuration file. This function returns the configuration as key -> value pairs. The value may
   * contain another associative array, if the configuration syntax supports this.
   *
   * This function may cache the parsing result for better performance
   *
   * @return array an associative array containing the configuration as key -> value pairs.
   *
   * @throws ParseException if the file cannot be parsed by this loader
   */
  public function parseFile() {
    foreach ([false, true] as $deep) { // first try with flat match to avoid parsing the same file over and over again
      foreach (self::getConfigurationLoaders() as $loaderClass) {
        $loader = new $loaderClass($this->getFilename()); // TODO cache instances

        if ($loader->checkFile($deep)) {
          return $loader->parseFile();
        }
      }
    }

    throw new ParseException("$this->filename cannot be parsed by any configured configuration loaders");
  }

  /**
   * @return array all configuration loaders configured
   */
  public static function getConfigurationLoaders() {
    return self::$configurationLoaders;
  }
}
