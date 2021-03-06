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


use exc\ConfigurationNotFoundException;
use Fink\config\exc\ParseException;

interface ConfigurationLoader {

  /**
   * ConfigurationLoader constructor.
   *
   * Create a new loader for a given file.
   *
   * @param $accessor string accessor to the configuration. May be a file name
   */
  public function __construct($accessor);

  /**
   * @return string the string to access the configuration
   */
  public function getAccessor();

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
  public function checkConfiguration($deep = false);

  /**
   * Parse a given configuration file. This function returns the configuration as key -> value pairs. The value may
   * contain another associative array, if the configuration syntax supports this.
   *
   * @return array an associative array containing the configuration as key -> value pairs.
   *
   * @throws ParseException if the file cannot be parsed by this loader
   */
  public function parseConfiguration();

  /**
   * This function works just like {@link ConfigurationLoader::parseConfiguration}, but caches the parsed
   * configuration in addition.
   *
   * @return array an associative array containing the configuration as key -> value pairs.
   *
   * @throws ParseException if the file cannot be parsed by this loader
   */
  public function parseAndCacheConfiguration();

}
