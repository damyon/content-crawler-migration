<?php

namespace Drupal\content_crawler_migration\Plugin\migrate_plus\data_parser;

use Drupal\migrate_plus\Plugin\migrate_plus\data_parser\Json;

/**
 * Obtain JSON data for migration.
 *
 * @DataParser(
 *   id = "flatten_json",
 *   title = @Translation("FLATTEN JSON")
 * )
 */
class FlattenJson extends Json {

  /**
   * Retrieves the JSON data and returns it as an array.
   *
   * @param string $url
   *   URL of a JSON feed.
   *
   * @return array
   *   The selected data to be iterated.
   *
   * @throws \GuzzleHttp\Exception\RequestException
   */
  protected function getSourceData($url) {
    $source_data = parent::getSourceData($url);
    $output = [];
    foreach ($source_data as $row) {
      $output = [
        'id' => $row,
        'url' => $row,
      ];
    }
    return $output;
  }

}
