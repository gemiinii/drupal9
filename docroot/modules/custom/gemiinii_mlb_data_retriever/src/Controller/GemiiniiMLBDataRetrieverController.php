<?php

namespace Drupal\gemiinii_mlb_data_retriever\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\gemiinii_mlb_data_retriever\GemiiniiMLBDataRetriever;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * An example controller.
 */
class GemiiniiMLBDataRetrieverController extends ControllerBase {

  protected $dataRetriever;

  // this creates the instance by assigning the data retriever
  // that the create function gave us to our local var.
  public function __construct(GemiiniiMLBDataRetriever $data_retriever) {
    $this->dataRetriever = $data_retriever;
  }

  /**
   * {@inheritdoc}
   */
  // look at it this way - create is a static function whose purpose
  // is to get any params that must be passed to construct. It defines
  // the overall setup for when instances are created.
  // so in this case, I need the mlb data retriever service
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('gemiinii.mlb_data_retriever')
    );  
  }


  /**
   * Returns a render-able array.
   */
  public function getUniformNumber() {
    $response = $this->dataRetriever->get_player_number(493316);
    $build = [
      '#markup' => $response,
    ];
    return $build;
  }

}