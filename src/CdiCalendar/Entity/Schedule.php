<?php

namespace CdiCalendar\Entity;

use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Proxy\Proxy;
use Gedmo\Mapping\Annotation as Gedmo;
use Zend\InputFilter\InputFilter;
use Zend\Form\Annotation;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="cdi_schedule")
 *
 * @author Cristian Incarnato
 */
class Schedule extends \CdiCommons\Entity\AbstractEntity {

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Type("Zend\Form\Element\Hidden")
     */
    protected $id;

     /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({
     * "label":"Calendar:",
     * "empty_option": "",
     * "target_class":"CdiCalendar\Entity\Calendar",
     * "property": "id"})
     * @ORM\ManyToOne(targetEntity="CdiCalendar\Entity\Calendar")
     * @ORM\JoinColumn(name="calendar_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $calendar;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({
     * "label":"Day Of Week:",
     * "empty_option": "",
     * "target_class":"CdiCalendar\Entity\DayOfWeek",
     * "property": "id"})
     * @ORM\ManyToOne(targetEntity="CdiCalendar\Entity\DayOfWeek")
     * @ORM\JoinColumn(name="day_of_week_id", referencedColumnName="id")
     */
    protected $dayOfWeek;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"StartTime:"})
     * @Annotation\Validator({"name":"Date", "options":{"format":"H:i"}})
     * @ORM\Column(type="time", nullable=true, name="start_time")
     */
    protected $startTime;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"EndTime:"})
     * @Annotation\Validator({"name":"Date", "options":{"format":"H:i"}})
     * @ORM\Column(type="time", nullable=true, name="end_time")
     */
    protected $endTime;

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }
    
    function getDayOfWeek() {
        return $this->dayOfWeek;
    }

    function getStartTime() {
        return $this->startTime;
    }

    function getEndTime() {
        return $this->endTime;
    }

    function setDayOfWeek($dayOfWeek) {
        $this->dayOfWeek = $dayOfWeek;
    }

    function setStartTime($startTime) {
        $this->startTime = $startTime;
    }

    function setEndTime($endTime) {
        $this->endTime = $endTime;
    }
    
    function getCalendar() {
        return $this->calendar;
    }

    function setCalendar($calendar) {
        $this->calendar = $calendar;
    }




}
