<?php

namespace Drupal\mycustom\services;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DrupalDateTime;


/**
 * Class TimezoneService
 */
class TimezoneService
{

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;


  /**
   * Constructs a new object.
   */
  public function __construct(ConfigFactoryInterface $config_factory)
  {
    $this->configFactory = $config_factory;
  }

  /**
   *
   */
  public function getConfigFactory()
  {
    return $this->configFactory;
  }

  /**
   *
   */
  public function getTimezoneConfig()
  {
    return $this->configFactory->getEditable('mycustom.timestamp_config')->get();
  }

  /**
   *
   */
  public function displayTimezone() {
    // Getting the stored configurations
    $config = $this->getTimezoneConfig();
    // Getting Timezont Config base URL.
    $timezone_config = $config['timezone'];
    //set default_timezone
    date_default_timezone_set($timezone_config);
    //Set current time
    $current_time =  date("jS F Y h:i:s A");
    return  $current_time; 
  }
}
  