<?php

namespace DeliveryArretado\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Silex\Api\BootableProviderInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * 
 * Description of SettingsServiceProvider
 * 
 * @package DeliveryArretado
 * @author Anderson Emanuel <contato@andersonemanuel.com.br>
 * @copyright (c) 2017, Anderson Emanuel
 * @version 1.0
 */
class SettingsServiceProvider implements ServiceProviderInterface, BootableProviderInterface {

    /**
     *
     * @var type 
     */
    private $file;

    /**
     * 
     * @param type $file
     */
    public function __construct($file) {
        $this->file = $file;
    }

    /**
     * 
     * @param Application $app
     */
    public function boot(Application $app) {
        
    }

    /**
     * 
     * @param Yaml $settings
     * @param Container $app
     */
    public function importSearch(&$settings, $app) {
        foreach ($settings as $key => $value) {
            if ($key == 'imports') {
                foreach ($value as $resource) {
                    $base_dir = str_replace(basename($this->file), '', $this->file);
                    $new_settings = new SettingsServiceProvider($base_dir . $resource['resource']);
                    $new_settings->register($app);
                }
                unset($settings['imports']);
            }
        }
    }

    /**
     * 
     * @param Container $container
     */
    public function register(Container $container) {
        $settings = Yaml::parse(file_get_contents($this->file));
        if (is_array($settings)) {
            $this->importSearch($settings, $container);
            if (isset($container['settings']) && is_array($container['settings'])) {
                $container['settings'] = array_replace_recursive($container['settings'], $settings);
            } else {
                $container['settings'] = $settings;
            }
        }
    }

}
