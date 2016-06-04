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


use Fink\config\exc\ParseException;

class ValueParser {

  public function parseIntelligent($value) {
    $functions = [
      "parseNumeric",
      "parseBoolean",
      "parseString"
    ];

    foreach ($functions as $function) {
      try {
        return call_user_func([$this, $function], $value);
      } catch (ParseException $e) {
        // empty on purpose
      }
    }

    $exportValue = var_export($value, true);
    throw new ParseException("'$exportValue' could not be parsed by any parser");
  }

  /**
   * Make this numeric element a number of the correct type.
   *
   * See @link http://php.net/manual/de/function.is-numeric.php#107326
   *
   * @param mixed $value the value
   * @return int|float the parsed value
   *
   * @throws ParseException if the element is not numeric
   */
  public function parseNumeric($value) {
    if (is_numeric($value)) {
      return $value + 0;
    }

    $exportValue = var_export($value, true);
    throw new ParseException("'$exportValue' could not be parsed as a number");
  }

  /**
   * See @link http://php.net/manual/en/function.is-bool.php#113693
   *
   * @param string|bool $value
   * @return bool
   *
   * @throws ParseException if the value could not be parsed
   */
  public function parseBoolean($value) {
    if (is_bool($value)) return $value;

    $exportValue = var_export($value, true);
    $e = new ParseException("$exportValue could not be parsed as a boolean");

    if (!is_string($value)) throw $e;

    switch (strtolower($value)) {
      case 'true':
      case 'on':
      case 'yes':
      case 'y':
        return true;
      case 'false':
      case 'off':
      case 'no':
      case 'n':
        return false;
      default:
        throw $e;
    }
  }

  /**
   * Tests, if the given value is of type string
   *
   * @param mixed $value the value
   * @return string the value as string
   * @throws ParseException
   */
  public function parseString($value) {
    if (is_string($value)) {
      return $value;
    }

    $exportValue = var_export($value, true);
    throw new ParseException("'$exportValue' can not be parsed as a string");
  }

}
