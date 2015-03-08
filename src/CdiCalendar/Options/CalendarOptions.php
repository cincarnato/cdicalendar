<?php

namespace CdiCalendar\Options;

use Zend\Stdlib\AbstractOptions;

class CalendarOptions extends AbstractOptions implements
CalendarOptionsInterface {

    protected $calendarEntityClass;
   
    function getCalendarEntityClass() {
        return $this->calendarEntityClass;
    }

    function setCalendarEntityClass($calendarEntityClass) {
        $this->calendarEntityClass = $calendarEntityClass;
    }





}
