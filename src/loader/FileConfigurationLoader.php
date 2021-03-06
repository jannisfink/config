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


use Fink\config\cache\ConfigurationCache;
use Fink\config\exc\ConfigurationNotFoundException;
use Fink\config\exc\ParseException;

/**
 * Interface ConfigurationLoader
 *
 * Classes implementing this interface are meant to be used to parse configuration files and return the results.
 *
 * @package Fink\config\loader
 */
abstract class FileConfigurationLoader implements ConfigurationLoader {

  private $filename;

  /**
   * An array of all supported file types
   */
  public static $supportedFileTypes = [];

  /**
   * ConfigurationLoader constructor.
   *
   * Create a new loader for a given file.
   *
   * @param $accessor string the file name
   */
  public final function __construct($accessor) {
    $this->filename = $accessor;
  }

  /**
   * @return string the name of the configuration file to read
   */
  public function getAccessor() {
    return $this->filename;
  }

  /**
   * Checks, if a given file can be parsed by this configuration loader. If the file type is supported
   * by this loader, this function will return true without further checking for correct syntax of the
   * configuration file.
   *
   * If the deep parameter is set to true, this function will try to parse the file formats to test
   * whether they can be parsed or not.
   *
   * @param $deep bool if set to true, this function will just look for the file extension
   * @return bool true, if the given file can be parsed by this loader, false else
   *
   * @throws ConfigurationNotFoundException if the given accessor accesses no valid configuration
   */
  public final function checkConfiguration($deep = false) {
    if (!file_exists($this->filename) || !is_readable($this->filename)) {
      throw new ConfigurationNotFoundException("File $this->filename does not exist or is not readable");
    }

    $fileExtension = pathinfo($this->filename, PATHINFO_EXTENSION);
    if (in_array($fileExtension, static::$supportedFileTypes)) {
      return true;
    }

    if (!$deep) {
      return false;
    }

    try {
      $this->parseAndCacheConfiguration();
      return true;
    } catch (ParseException $e) {
      return false;
    }
  }

  /**
   * This function works just like {@link ConfigurationLoader::parseConfiguration}, but caches the parsed
   * configuration in addition.
   *
   * @return array an associative array containing the configuration as key -> value pairs.
   *
   * @throws ParseException if the file cannot be parsed by this loader
   */
  public final function parseAndCacheConfiguration() {
    if (ConfigurationCache::isCached(static::class, $this->filename)) {
      return ConfigurationCache::getCached(static::class, $this->filename);
    }

    $result = $this->parseConfiguration();
    ConfigurationCache::addToCache(static::class, $this->filename, $result);
    return $result;
  }

}
