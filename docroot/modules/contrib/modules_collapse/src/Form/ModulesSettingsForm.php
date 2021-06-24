<?php

namespace Drupal\modules_collapse\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ModulesSettingsForm.
 */
class ModulesSettingsForm extends ConfigFormBase {

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->configFactory = $container->get('config.factory');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'modules_collapse.modulessettings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'modules_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('modules_collapse.modulessettings');
    $form['collapse_modules_package_groups'] = [
      '#type' => 'radios',
      '#title' => $this->t('Collapse Modules Package Groups'),
      '#description' => $this->t('If set to yes the package groups on the Extend admin page will be closed by default.'),
      '#options' => [
        'Yes' => $this->t('Yes'),
        'No' => $this->t('No'),
      ],
      '#default_value' => ($config->get('collapse_modules_package_groups') === 'Yes') ? 'Yes' : 'No',
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('modules_collapse.modulessettings')
      ->set('collapse_modules_package_groups', $form_state->getValue('collapse_modules_package_groups'))
      ->save();
  }

}
