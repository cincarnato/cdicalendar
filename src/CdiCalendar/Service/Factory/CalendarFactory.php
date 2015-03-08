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
class CalendarFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $options = $serviceLocator->get('cdicalendar_options');
        $Calendar = new \CdiCalendar\Service\Calendar($options);
        $Calendar->initService();
        return $Calendar;
    }

}

?>
