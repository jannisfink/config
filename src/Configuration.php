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


/**
 * Class Configuration
 *
 * Read a configuration from file.
 *
 * @package Fink\config
 */
class Configuration {

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

  /**
   * Create a new configuration instance.
   *
   * @param string $file the filename of the configuration file as an absolute path.
   * @param int $format format of the configuration file. Intelligent guess, if not given.
   */
  public function __construct($file, $format = Configuration::AUTO) {

  }

  /**
   * Read a specific key from the configuration. It will return all configuration values
   * with the type they are stored in the configuration file (int, bool, string...)
   *
   * @param array ...$path the key or keys matching a specific configuration value
   * @return mixed the value of the key given.
   */
  public function get(...$path) {

  }

}
