<?php

namespace Drupal\devel\Controller;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Render\ElementInfoManagerInterface;
use Drupal\Core\Url;
use Drupal\devel\DevelDumperManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Provides route responses for the element info page.
 */
class ElementInfoController extends ControllerBase {

  /**
   * Element info manager service.
   *
   * @var \Drupal\Core\Render\ElementInfoManagerInterface
   */
  protected $elementInfo;

  /**
   * The dumper service.
   *
   * @var \Drupal\devel\DevelDumperManagerInterface
   */
  protected $dumper;

  /**
   * EventInfoController constructor.
   *
   * @param \Drupal\Core\Render\ElementInfoManagerInterface $element_info
   *   Element info manager service.
   * @param \Drupal\devel\DevelDumperManagerInterface $dumper
   *   The dumper service.
   */
  public function __construct(ElementInfoManagerInterface $element_info, DevelDumperManagerInterface $dumper) {
    $this->elementInfo = $element_info;
    $this->dumper = $dumper;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('element_info'),
      $container->get('devel.dumper')
    );
  }

  /**
   * Builds the element overview page.
   *
   * @return array
   *   A render array as expected by the renderer.
   */
  public function elementList() {
    $headers = [
      $this->t('Name'),
      $this->t('Provider'),
      $this->t('Class'),
      $this->t('Operations'),
    ];

    $rows = [];

    foreach ($this->elementInfo->getDefinitions() as $element_type => $definition) {
      $row['name'] = [
        'data' => $element_type,
        'filter' => TRUE,
      ];
      $row['provider'] = [
        'data' => $definition['provider'],
        'filter' => TRUE,
      ];
      $row['class'] = [
        'data' => $definition['class'],
        'filter' => TRUE,
      ];
      $row['operations']['data'] = [
        '#type' => 'operations',
        '#links' => [
          'devel' => [
            'title' => $this->t('Devel'),
            'url' => Url::fromRoute('devel.elements_page.detail', ['element_name' => $element_type]),
            'attributes' => [
              'class' => ['use-ajax'],
              'data-dialog-type' => 'modal',
              'data-dialog-options' => Json::encode([
                'width' => 700,
                'minHeight' => 500,
              ]),
            ],
          ],
        ],
      ];

      $rows[$element_type] = $row;
    }

    ksort($rows);

    $output['elements'] = [
      '#type' => 'devel_table_filter',
      '#filter_label' => $this->t('Search'),
      '#filter_placeholder' => $this->t('Enter element id, provider or class'),
      '#filter_description' => $this->t('Enter a part of the element id, provider or class to filter by.'),
      '#header' => $headers,
      '#rows' => $rows,
      '#empty' => $this->t('No elements found.'),
      '#sticky' => TRUE,
      '#attributes' => [
        'class' => ['devel-element-list'],
      ],
    ];

    return $output;
  }

  /**
   * Returns a render array representation of the element.
   *
   * @param string $element_name
   *   The name of the element to retrieve.
   *
   * @return array
   *   A render array containing the element.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
   *   If the requested element is not defined.
   */
  public function elementDetail($element_name) {
    if (!$element = $this->elementInfo->getDefinition($element_name, FALSE)) {
      throw new NotFoundHttpException();
    }

    $element += $this->elementInfo->getInfo($element_name);
    return $this->dumper->exportAsRenderable($element, $element_name);
  }

}
