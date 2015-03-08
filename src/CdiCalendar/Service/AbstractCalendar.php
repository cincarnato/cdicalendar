<?php

namespace CdiTools\Service;

use CdiCalendar\Options\CalendarOptionsInterface;

/**
 * Description of GoogleApi
 *
 * @author cincarnato
 */
abstract class AbstractCalendar {

    //put your code here

    protected $entity;


    function __construct(CalendarOptionsInterface $options) {

        $this->apiId = $options->getApiId();
       
        
    }

    function getEntity() {
        return $this->entity;
    }

    function setEntity($entity) {
        $this->entity = $entity;
    }




}

?>
