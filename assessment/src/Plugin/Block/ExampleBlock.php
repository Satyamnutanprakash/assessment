<?php

namespace Drupal\assessment\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides an example block.
 *
 * @Block(
 *   id = "assessment_example",
 *   admin_label = @Translation("Example"),
 *   category = @Translation("assessment")
 * )
 */
class ExampleBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The config factory service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Construct function.
   *
   * @param array $configuration
   *   It is the configuration.
   * @param string $plugin_id
   *   It is the plugin id.
   * @param mixed $plugin_definition
   *   It is the Plugin definition.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   It is config factory service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
  }

  /**
   * Dependency injection.
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory')
    );
  }

  /**
   * Returns rendered output for the block.
   */
  public function build() {
    $config = $this->configFactory->getEditable('assessment.settings');
    $title = $config->get('title');
    $text = $config->get('text')['value'];
    $display = $config->get('display');

    $elements['title'] = [
      '#markup' => '<h3>' . $title . '</h3>',
    ];

    if ($display) {
      $elements['text'] = [
        '#markup' => $text,
      ];
    }

    return $elements;
  }

  /**
   * Makes Cache invalidated.
   */
  public function getCacheMaxAge() {
    return 0;
  }

}
