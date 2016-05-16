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

class JsonConfigurationLoaderTest extends \PHPUnit_Framework_TestCase {

  const VALID_JSON_WITH_EXTENSION = __DIR__ . "/valid_json.json";
  const VALID_JSON_NO_EXTENSION = __DIR__ . "/valid_json";
  const INVALID_JSON_WITH_EXTENSION = __DIR__ . "/invalid_json.json";
  const INVALID_JSON_NO_EXTENSION = __DIR__ . "/invalid_json";

  public function testGetSupportedFileTypes() {
    $this->assertEquals(["json"], JsonConfigurationLoader::getSupportedFileTypes());
  }

  public function testParseFileValidJson() {
    $withExtension = JsonConfigurationLoader::parseFile(self::VALID_JSON_WITH_EXTENSION);
    $withoutExtension = JsonConfigurationLoader::parseFile(self::VALID_JSON_NO_EXTENSION);

    $this->assertEquals(["key" => "value"], $withExtension);
    $this->assertEquals(["key" => "value"], $withoutExtension);
  }

  public function testParseFileInvalidJsonWithException() {
    $this->setExpectedException(ParseException::class);

    JsonConfigurationLoader::parseFile(self::INVALID_JSON_WITH_EXTENSION);
  }

  public function testParseFileInvalidJsonWithoutException() {
    $this->setExpectedException(ParseException::class);

    JsonConfigurationLoader::parseFile(self::INVALID_JSON_NO_EXTENSION);
  }

  public function testCheckFileWithExtension() {
    $this->assertTrue(JsonConfigurationLoader::checkFile(self::VALID_JSON_WITH_EXTENSION));
    $this->assertTrue(JsonConfigurationLoader::checkFile(self::INVALID_JSON_WITH_EXTENSION));
  }

  public function testCheckFileWithoutExtension() {
    $this->assertTrue(JsonConfigurationLoader::checkFile(self::VALID_JSON_NO_EXTENSION));
    $this->assertFalse(JsonConfigurationLoader::checkFile(self::INVALID_JSON_NO_EXTENSION));
  }

}
