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


class ConfigurationCacheTest extends \PHPUnit_Framework_TestCase {

  public function testIsCachedEmptyCache() {
    $this->assertFalse(ConfigurationCache::isCached("some", "key"));
  }

  public function testAddGetData() {
    $identifier = "identifier";
    $accessor = "accessor";
    $data = ["key" => "value"];

    ConfigurationCache::addToCache($identifier, $accessor, $data);

    $this->assertTrue(ConfigurationCache::isCached($identifier, $accessor));
    $this->assertEquals($data, ConfigurationCache::getCached($identifier, $accessor));
  }

  public function testAddDataTwice() {
    $this->expectException(\Exception::class);

    $identifier = "other";
    $accessor = "path";
    $data = ["key" => "value"];

    ConfigurationCache::addToCache($identifier, $accessor, $data);
    ConfigurationCache::addToCache($identifier, $accessor, $data);
  }

  public function testGetDataFalse() {
    $this->assertFalse(ConfigurationCache::getCached("some", "nonexistent"));
  }

}
