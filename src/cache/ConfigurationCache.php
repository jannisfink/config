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


/**
 * Class ConfigurationCache
 *
 * Class to cache already parsed configuration
 *
 * @package Fink\config\cache
 */
class ConfigurationCache {

  private static $cache = [];

  /**
   * Check, if the cache has stored a value for the given identifier and accessor.
   *
   * @param $identifier string identifier of the configuration loader
   * @param $accessor string accessor of the configuration loader
   * @return bool true, if the cache has an entry for given identifier and accessor
   */
  public static function isCached($identifier, $accessor) {
    return array_key_exists($identifier, self::$cache) && array_key_exists($accessor, self::$cache[$identifier]);
  }

  /**
   * Add new data to the cache.
   *
   * @param $identifier string identifier of the configuration loader
   * @param $accessor string accessor of the configuration loader
   * @param $data array data for this accessor/identifier pair
   *
   * @throws \Exception if some data is already stored for the given identifier/accessor pair.
   */
  public static function addToCache($identifier, $accessor, array $data) {
    if (self::isCached($identifier, $accessor)) {
      throw new \Exception("Data for identifier '$identifier' and accessor '$accessor' is already present in
      this cache");
    }

    if (!in_array($identifier, self::$cache)) {
      self::$cache[$identifier] = [];
    }

    self::$cache[$identifier][$accessor] = $data;
  }

  /**
   * Access a given data set of this cache.
   *
   * @param $identifier string identifier of the configuration loader
   * @param $accessor string accessor of the configuration loader
   * @return array|bool the cached data, false, if no such data exists
   */
  public static function getCached($identifier, $accessor) {
    if (!self::isCached($identifier, $accessor)) {
      return false;
    }

    return self::$cache[$identifier][$accessor];
  }

}
