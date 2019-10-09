<?php

namespace Drupal\content_crawler_migration\Plugin\migrate\process;

use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;

/**
 * Parse the body and apply replacements.
 *
 * @package Drupal\content_crawler_migration\Plugin\migrate\process
 *
 * @MigrateProcessPlugin(
 *   id = "body_parser"
 * )
 */
class BodyParser extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    $value = $this->replaceImg($value, '/sites/default/files/');
    return $value;
  }

  /**
   * Update image source.
   *
   * @param string $content
   *   - The content to replace.
   * @param string $path
   *   - The path to insert.
   *
   * @return string
   *   - Content with image replaces.
   */
  public function replaceImg($content, $path) {
    preg_match_all('@src="([^"]+)"@', $content, $match);
    $src = array_pop($match);
    foreach ($src as $img_src) {
      $content = str_replace($img_src, $path . basename($img_src), $content);
    }
    return $content;
  }

}
