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

use Fink\config\exc\ParseException;


class AutoConfigurationLoaderTest extends \PHPUnit_Framework_TestCase {

  const VALID_JSON_WITH_EXTENSION = __DIR__ . "/valid_json.json";
  const VALID_JSON_NO_EXTENSION = __DIR__ . "/valid_json";
  const INVALID_JSON_WITH_EXTENSION = __DIR__ . "/invalid_json.json";
  const INVALID_JSON_NO_EXTENSION = __DIR__ . "/invalid_json";

  const VALID_INI = __DIR__ . "/valid_ini.ini";
  const INVALID_INI = __DIR__ . "/invalid_ini.ini";

  public function testParseValidJsonWithExtension() {
    $loader = new AutoConfigurationLoader(self::VALID_JSON_WITH_EXTENSION);

    $this->assertEquals(["key" => "value"], $loader->parseFile());
  }

  public function testParseValidIniWithExtension() {
    $loader = new AutoConfigurationLoader(self::VALID_INI);

    $this->assertEquals(["section" => ["key" => "value"]], $loader->parseFile());
  }

  public function testParseValidJsonWithoutExtension() {
    $loader = new AutoConfigurationLoader(self::VALID_JSON_NO_EXTENSION);

    $this->assertEquals(["key" => "value"], $loader->parseFile());
  }

  public function testParseInvalidJsonWithExtension() {
    $this->setExpectedException(ParseException::class);

    $loader = new AutoConfigurationLoader(self::INVALID_JSON_WITH_EXTENSION);

    $loader->parseFile();
  }

  public function testParseInvalidJsonWithoutExtension() {
    $this->setExpectedException(ParseException::class);

    $loader = new AutoConfigurationLoader(self::INVALID_JSON_NO_EXTENSION);

    $loader->parseFile();
  }

  public function testParseInvalidIniWithExtension() {
    $this->setExpectedException(ParseException::class);

    $loader = new AutoConfigurationLoader(self::INVALID_INI);

    $loader->parseFile();
  }

}
