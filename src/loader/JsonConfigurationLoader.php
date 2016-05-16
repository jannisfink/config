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

class JsonConfigurationLoader extends ConfigurationLoader {

  public static $supportedFileTypes = ["json"];

  /**
   * Parse a given configuration file. This function returns the configuration as key -> value pairs. The value may
   * contain another associative array, if the configuration syntax supports this.
   *
   * This function may cache the parsing result for better performance
   *
   * @return array an associative array containing the configuration as key -> value pairs.
   *
   * @throws ParseException if the file cannot be parsed by this loader
   */
  public function parseFile() {
    $filename = $this->getFilename();
    $fileContents = file_get_contents($filename);
    $parsingResult = json_decode($fileContents, true);

    if ($parsingResult == null) {
      throw new ParseException("$filename is no valid json file");
    }

    // TODO: cache?
    return $parsingResult;
  }
}
