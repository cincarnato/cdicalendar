<?php

namespace CdiCalendar\Service\Factory;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of GoogleApiAnalyticsFactory
 *
 * @author cincarnato
 */
class AgendaFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $options = $serviceLocator->get('cdicalendar_options');
        $Agenda = new \CdiCalendar\Service\Agenda($options);
        $Agenda->initService();
        return $Agenda;
    }

}

?>
