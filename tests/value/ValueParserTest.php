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

class ValueParserTest extends \PHPUnit_Framework_TestCase {

  /**
   * @var ValueParser
   */
  private $valueParser;

  protected function setUp() {
    $this->valueParser = new ValueParser();
  }

  public function testParseNumericNumeric() {
    $this->assertTrue($this->valueParser->parseNumeric("1") === 1);
    $this->assertTrue($this->valueParser->parseNumeric("1.7") === 1.7);
  }

  public function testParseNumericNonNumeric() {
    $this->expectException(ParseException::class);

    $this->valueParser->parseNumeric("non numeric");
  }

  public function testParseBooleanBoolean() {
    $this->assertTrue($this->valueParser->parseBoolean("y"));
    $this->assertTrue($this->valueParser->parseBoolean(true));
    $this->assertFalse($this->valueParser->parseBoolean("n"));
    $this->assertFalse($this->valueParser->parseBoolean(false));
  }

  public function testParseBooleanString() {
    $this->expectException(ParseException::class);

    $this->assertFalse($this->valueParser->parseBoolean("this is no boolean value"));
  }

  public function testParseBooleanArray() {
    $this->expectException(ParseException::class);

    $this->assertFalse($this->valueParser->parseBoolean([]));
  }

  public function testParseStringString() {
    $this->assertEquals("test", $this->valueParser->parseString("test"));
  }

  public function testParseStringNumber() {
    $this->expectException(ParseException::class);

    $this->valueParser->parseString(2);
  }

  public function testParseIntelligentFloatFromString() {
    $this->assertEquals(1.2, $this->valueParser->parseIntelligent("1.2"));
  }

  public function testParseIntelligentUnSupportedObject() {
    $this->expectException(ParseException::class);

    $this->valueParser->parseIntelligent([]);
  }

}
