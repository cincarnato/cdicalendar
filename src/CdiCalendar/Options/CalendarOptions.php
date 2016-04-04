<?php

namespace CdiCalendar\Options;

use Zend\Stdlib\AbstractOptions;

class AgendaOptions extends AbstractOptions implements
AgendaOptionsInterface {

    protected $calendarEntityClass;
   
    function getAgendaEntityClass() {
        return $this->calendarEntityClass;
    }

    function setAgendaEntityClass($calendarEntityClass) {
        $this->calendarEntityClass = $calendarEntityClass;
    }





}
