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

class IniConfigurationLoaderTest extends \PHPUnit_Framework_TestCase {

  const VALID_INI = __DIR__ . "/resources/valid_ini.ini";
  const INVALID_INI = __DIR__ . "/resources/invalid_ini.ini";

  public function testGetSupportedFileTypes() {
    $this->assertEquals(["ini"], IniConfigurationLoader::$supportedFileTypes);
  }

  public function testParseFileValidIni() {
    $loader = new IniConfigurationLoader(self::VALID_INI);

    $this->assertEquals(["section" => ["key" => "value"]], $loader->parseConfiguration());
  }

  public function testParseFileInvalidIni() {
    $this->expectException(ParseException::class);

    $loader = new IniConfigurationLoader(self::INVALID_INI);
    $loader->parseConfiguration();
  }

}
