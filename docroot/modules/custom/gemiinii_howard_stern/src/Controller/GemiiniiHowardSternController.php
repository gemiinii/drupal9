<?php

namespace Drupal\gemiinii_howard_stern\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\gemiinii_mlb_data_retriever\GemiiniiMLBDataRetriever;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * An example controller.
 */
class GemiiniiHowardSternController extends ControllerBase {

  public function splash() {
    $response = "Hello hello";
    $build = [
      '#markup' => $response,
    ];
    return $build;
  }


}