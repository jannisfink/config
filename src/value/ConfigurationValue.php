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

namespace Fink\config\value;
use Fink\config\Configuration;


/**
 * Class ConfigurationValue
 *
 * Class to represent a configuration value
 *
 * @package Fink\config
 */
class ConfigurationValue {

  const NESTED_CONFIGURATION_REGEX = "/\$\{(?<key>.*)\}/";

  const NESTED_CONFIGURATION_PATH_DIVIDER = "/";

  private $value;

  private $configuration;

  /**
   * ConfigurationValue constructor.
   *
   * @param Configuration $configuration the configuration instance of this value
   * @param mixed $value some value
   */
  public function __construct(Configuration $configuration, $value) {
    $this->configuration = $configuration;
    $this->value = $value;
  }

  /**
   * @return mixed the unparsed value
   */
  public function getRawValue() {
    return $this->value;
  }

  /**
   * Parse the configuration value and return the parsed result
   *
   * @return mixed the parsed value
   */
  public function parse() {
    $value = $this->getRawValue();
    $matches = [];
    if (is_array($value)) {
      return $value;
    } elseif (is_numeric($value)) {
      return $this->getNumeric($value);
    } elseif(is_bool($value)) {
      return (bool) $value;
    } elseif (preg_match(self::NESTED_CONFIGURATION_REGEX, $value, $matches) === 1) {
      return $this->parseNestedValue($value, $matches);
    }

    return $value;
  }

  private function parseNestedValue($value, $matches) {
    $keys = explode(self::NESTED_CONFIGURATION_PATH_DIVIDER, $matches["key"]);
    $valueToReplace = $this->configuration->get($keys);

    return preg_replace(self::NESTED_CONFIGURATION_REGEX, $valueToReplace, $value);
  }

  /**
   * Make this numeric element a number of the correct type.
   *
   * See @link http://php.net/manual/de/function.is-numeric.php#107326
   *
   * @param mixed $value the value
   * @return int|float the parsed value, 0, if it is not parsable
   */
  private function getNumeric($value) {
    if (is_numeric($value)) {
      return $value + 0;
    }
    return 0;
  }

}
