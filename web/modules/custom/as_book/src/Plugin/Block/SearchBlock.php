<?php

namespace Drupal\as_book\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'SearchBlock' block.
 *
 * @Block(
 *  id = "search_block",
 *  admin_label = @Translation("Search block"),
 * )
 */
class SearchBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    $form = \Drupal::formBuilder()->getForm('\Drupal\as_book\Form\BookSearchForm');

    $build['search_block'] = $form;

    return $build;
  }

}
