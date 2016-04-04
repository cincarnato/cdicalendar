<?php

namespace CdiCalendar\Service;

use CdiCalendar\Options\AgendaOptionsInterface;

/**
 * Description of GoogleApi
 *
 * @author cincarnato
 */
abstract class AbstractAgenda {

    //put your code here

    protected $entity;


    function __construct(AgendaOptionsInterface $options) {

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
