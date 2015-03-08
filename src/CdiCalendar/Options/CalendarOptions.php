<?php

namespace CdiCalendar\Options;

use Zend\Stdlib\AbstractOptions;

class CalendarOptions extends AbstractOptions implements
CalendarOptionsInterface {

    protected $entity;
   
    function getEntity() {
        return $this->entity;
    }

    function setEntity($entity) {
        $this->entity = $entity;
    }





}
