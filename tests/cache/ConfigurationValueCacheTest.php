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

namespace Fink\config\cache;


use Fink\config\exc\IllegalArgumentException;

class ConfigurationValueCacheTest extends \PHPUnit_Framework_TestCase {

  /**
   * @var ConfigurationValueCache
   */
  private $classUnderTest;

  public function setUp() {
    $this->classUnderTest = new ConfigurationValueCache();
  }

  public function testIsCachedNonexistingValue() {
    $this->assertFalse($this->classUnderTest->isCached("sone nonexisting"));
  }

  public function testGetNonexistingValue() {
    $this->expectException(IllegalArgumentException::class);

    $this->classUnderTest->get("some nonexisting");
  }

  public function testDeleteNonexistingValue() {
    $this->expectException(IllegalArgumentException::class);

    $this->classUnderTest->delete("some nonexisting");
  }

  public function testIsCachedExistingValue() {
    $id = "id";

    $this->classUnderTest->put($id, "test");

    $this->assertTrue($this->classUnderTest->isCached($id));
  }

  public function testDeleteExistingValue() {
    $id = "id";

    $this->classUnderTest->put($id, "test");
    $this->classUnderTest->delete($id);

    $this->assertFalse($this->classUnderTest->isCached($id));
  }

  public function testGetExistingValue() {
    $id = "id";
    $value = "test";

    $this->classUnderTest->put($id, $value);

    $this->assertEquals($this->classUnderTest->get($id), $value);
  }

}
