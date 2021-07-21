<?php

namespace Drupal\gemiinii_mlb_data_retriever\Controller;

use Drupal\Core\Controller\ControllerBase;
use GuzzleHttp\Client;

/**
 * An example controller.
 */
class GemiiniiMLBDataRetrieverController extends ControllerBase {

  /**
   * Returns a render-able array.
   */
  public function getUniformNumber() {
    $response = 23;
    $build = [
      '#markup' => 23,
    ];
    return $build;
  }

}