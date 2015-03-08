<?php

namespace CdiCalendar;

class Module {

    public function getConfig() {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/../../src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function onBootstrap(\Zend\Mvc\MvcEvent $mvcEvent) {
        
    }

    public function getServiceConfig() {
        return array(
            'invokables' => array(
                'cdicalendar_service' => 'CdiCalendar\Service\Calendar',
            ),
            'factories' => array(
                'cdicalendar_options' => function ($sm) {
                    $config = $sm->get('Config');
                    return new Options\CalendarOptions(isset($config['CalendarOptions']) ? $config['CalendarOptions'] : array());
                },
                'cdicalendar_factory' => 'CdiCalendar\Service\Factory\CalendarFactory',
               
            ),
        );
    }

}