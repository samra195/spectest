<?php

namespace Drupal\mycustom\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\mycustom\services\TimezoneService;


/**
 * Provides a Custom Block.
 *
 * @Block(
 *   id = "user_timezone_block",
 *   admin_label = @Translation("Timezone Block"),
 *   category = @Translation("Timezone Block"),
 * )
 */

class DisplayTimezoneBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var ConfigFactoryInterface $configFactory
   */
  protected $configFactory;

  /**
   * @var TimezoneService $timezoneService
   */
  protected $timezoneService;
  
  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   * @param \Drupal\mycustom\services\TimezoneService $timezone_service
   */
    public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory, 
      TimezoneService $timezone_service) {
      parent::__construct($configuration, $plugin_id, $plugin_definition);
      $this->configFactory = $config_factory;
      $this->timezoneService = $timezone_service;
    }

  /**
   * {@inheritdoc}
   */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
      return new static(
        $configuration,
        $plugin_id,
        $plugin_definition,
        $container->get('config.factory'),
        $container->get('mycustom.timezone_service')
      );
    }
    
    /**
     * {@inheritdoc}
     */
    
    public function build() {
        
      $config = $this->configFactory->get('mycustom.timestamp_config');
    
      $country = $config->get('country');
      $city = $config->get('city'); 
      $currentdate = $this->timezoneService->displayTimezone();

      $markup = '<h2>'.$city.','.$country.'</h2>';
      $markup.= '<span><strong>Current Time</strong><br>'.$currentdate.'</span>';

      return [
        '#type' => 'markup',
        '#markup' => $markup,
        '#cache' => [
          'max-age' => 0,
        ]
      ];
        
    }
  
  }