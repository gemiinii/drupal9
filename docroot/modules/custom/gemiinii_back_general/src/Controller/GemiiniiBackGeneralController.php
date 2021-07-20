<?php

namespace Drupal\gemiinii_back_general\Controller;

use Drupal\Core\Controller\ControllerBase;
use GuzzleHttp\Client;

/**
 * An example controller.
 */
class GemiiniiBackGeneralController extends ControllerBase {

  /**
   * Returns a render-able array.
   */
  public function linkFilter() {
    $client = \Drupal::httpClient();
    $response = 'Fail';
    try {
        $request = $client->get('https://www.google.com');
        $response = $request->getBody();
        debug($response);
    }
    catch (RequestException $e) {
        debug($e->getMessage());
    }
    $build = [
      '#markup' => $response,
    ];
    return $build;
  }

}