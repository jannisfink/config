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


class ConfigurationTest extends \PHPUnit_Framework_TestCase {

  const VALID_JSON = __DIR__ . "/loader/valid_json.json";
  const VALID_INI = __DIR__ . "/loader/valid_ini.ini";

  public function testLoadValidJsonExplicit() {
    $config = new Configuration(self::VALID_JSON, Configuration::JSON);

    $this->assertEquals(["key" => "value"], $config->get());
  }

  public function testLoadValidJsonImplicit() {
    $config = new Configuration(self::VALID_JSON);

    $this->assertEquals(["key" => "value"], $config->get());
    $this->assertEquals(["key" => "value"], $config->get());
  }

  public function testLoadValidIniExplicit() {
    $config = new Configuration(self::VALID_INI, Configuration::INI);

    $this->assertEquals(["section" => ["key" => "value"]], $config->get());
  }

  public function testGetExistingKey() {
    $config = new Configuration(self::VALID_JSON, Configuration::JSON);

    $this->assertEquals("value", $config->get("key"));
  }

  public function testGetNonExistingKey() {
    $this->setExpectedException(\Exception::class);

    $config = new Configuration(self::VALID_JSON, Configuration::JSON);

    $config->get("nonexistent");
  }

}
