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
    $this->assertEquals(["json"], JsonConfigurationLoader::SUPPORTED_FILE_TYPES);
  }

  public function testParseFileValidJson() {
    $withExtension = new JsonConfigurationLoader(self::VALID_JSON_WITH_EXTENSION);
    $withoutExtension = new JsonConfigurationLoader(self::VALID_JSON_NO_EXTENSION);

    $this->assertEquals(["key" => "value"], $withExtension->parseFile());
    $this->assertEquals(["key" => "value"], $withoutExtension->parseFile());
  }

  public function testParseFileInvalidJsonWithException() {
    $this->setExpectedException(ParseException::class);

    $loader = new JsonConfigurationLoader(self::INVALID_JSON_WITH_EXTENSION);
    $loader->parseFile();
  }

  public function testParseFileInvalidJsonWithoutException() {
    $this->setExpectedException(ParseException::class);

    $loader = new JsonConfigurationLoader(self::INVALID_JSON_NO_EXTENSION);
    $loader->parseFile();
  }

  public function testCheckFileWithExtension() {
    $valid = new JsonConfigurationLoader(self::VALID_JSON_WITH_EXTENSION);
    $invalid = new JsonConfigurationLoader(self::INVALID_JSON_WITH_EXTENSION);

    $this->assertTrue($valid->checkFile());
    $this->assertTrue($invalid->checkFile());
  }

  public function testCheckFileWithoutExtension() {
    $valid = new JsonConfigurationLoader(self::VALID_JSON_NO_EXTENSION);
    $invalid = new JsonConfigurationLoader(self::INVALID_JSON_NO_EXTENSION);

    $this->assertFalse($valid->checkFile());
    $this->assertFalse($invalid->checkFile());

    $this->assertTrue($valid->checkFile(true));
  }

}