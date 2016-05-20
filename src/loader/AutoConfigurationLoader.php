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

  private $accessor;

  /**
   * ConfigurationLoader constructor.
   *
   * Create a new loader for a given file.
   *
   * @param $accessor string the file name
   */
  public final function __construct($accessor) {
    $this->accessor = $accessor;
  }

  /**
   * @return string the name of the configuration file to read
   */
  public function getAccessor() {
    return $this->accessor;
  }

  /**
   * Checks, if a given file can be parsed by this configuration loader. If the file type is supported
   * by this loader, this function will return true without further checking for correct syntax of the
   * configuration file.
   *
   * If the deep parameter is set to true, this function will try to parse the file formats to test
   * whether they can be parsed or not.
   *
   * @param $deep bool if set to true, this function will just look for the file extension
   * @return bool true, if the given file can be parsed by this loader, false else
   */
  public function checkConfiguration($deep = false) {
    // theoretically, this class is capable of parsing every (most) given file. Nevertheless,
    // return always false to prevent an endless loop, while the auto configuration loader
    // selects himself for parsing a given configuration file
    return false;
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
  public function parseConfiguration() {
    foreach ([false, true] as $deep) { // first try with flat match to avoid parsing the same file over and over again
      foreach (Configuration::getConfigurationLoaders() as $loaderClass) {
        $loader = new $loaderClass($this->getAccessor()); // TODO cache instances

        if ($loader->checkConfiguration($deep)) {
          return $loader->parseConfiguration();
        }
      }
    }

    throw new ParseException("$this->accessor cannot be parsed by any configured configuration loaders");
  }

}
