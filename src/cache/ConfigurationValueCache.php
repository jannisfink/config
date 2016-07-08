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

/**
 * Class ConfigurationValueCache
 *
 * Class to store already accessed configuration values.
 *
 * @package Fink\config\cache
 */
class ConfigurationValueCache {

  private $cache;

  public function __construct() {
    $this->cache = [];
  }

  public function isCached($identifier) {
    return array_key_exists($identifier, $this->cache);
  }

  public function put($identifier, $value) {
    $this->cache[$identifier] = $value;
  }

  public function get($identifier) {
    if (!$this->isCached($identifier)) {
      throw new IllegalArgumentException("Cannot get a value which is not stored in this cache");
    }
    return $this->cache[$identifier];
  }

  public function delete($identifier) {
    if (!$this->isCached($identifier)) {
      throw new IllegalArgumentException("Cannot delete a value which is not stored in this cache");
    }
    unset($this->cache[$identifier]);
  }

}
