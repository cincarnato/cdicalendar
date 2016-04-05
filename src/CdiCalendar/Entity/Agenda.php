<?php

namespace CdiCalendar\Entity;

use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Proxy\Proxy;
use Gedmo\Mapping\Annotation as Gedmo;
use Zend\InputFilter\InputFilter;
use Zend\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * An example of how to implement a role aware user entity.
 *
 * @ORM\Entity
 * @ORM\Table(name="cdi_agenda")
 *
 * @author Cristian Incarnato
 */
class Agenda extends \CdiCommons\Entity\ExtendedEntity {
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Type("Zend\Form\Element\Hidden")
     */

    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, unique=false, nullable=true)
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(type="string", length=250, unique=false, nullable=true)
     */
    protected $description;

    /**
     * Duration in seconds
     * @var int 
     * @ORM\Column(type="integer")
     * 
     */
    protected $duration;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", unique=false, nullable=true, name="schedule_date")
     */
    protected $scheduledDate;

    /**
     * @var string
     * 
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="repeat_enable")
     */
    protected $repeatEnable;

    /**
     * Must be "day", "week", "month", "year"
     * @var string
     * @ORM\Column(type="string", length=20, unique=false, nullable=true, name="repeat_by")
     */
    protected $repeatBy;

    /**
     * Must be 0,1,2,3,4,5,6
     * @var string
     * @ORM\Column(type="string", length=14, unique=false, nullable=true, name="repeat_day")
     */
    protected $repeatDay;

    /**
     * 
     * @var int
     * @ORM\Column(type="integer", length=3, unique=false, nullable=true, name="repeat_every")
     */
    protected $repeatEvery;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", unique=false, nullable=true, name="repeat_finish_date")
     */
    protected $repeatFinishDate;

    /**
     * @var Boolean
     * @ORM\Column(type="boolean", unique=false, nullable=true)
     */
    protected $done;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", unique=false, nullable=true, name="done_date")
     */
    protected $doneDate;

    /*
     * @ORM\ManyToOne(targetEntity="CdiUser\Entity\User")
     * 
     */
    protected $user;

    public function __construct() {
        
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    function getTitle() {
        return $this->title;
    }

    function getDescription() {
        return $this->description;
    }

    function getScheduledDate() {
        return $this->scheduledDate;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setScheduledDate($scheduledDate) {
        $this->scheduledDate = $scheduledDate;
    }

    function getUser() {
        return $this->user;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function getDuration() {
        return $this->duration;
    }

    function getRepeatEnable() {
        return $this->repeatEnable;
    }

    function getRepeatBy() {
        return $this->repeatBy;
    }

    function getRepeatDay() {
        return $this->repeatDay;
    }

    function getRepeatEvery() {
        return $this->repeatEvery;
    }

    function getRepeatFinishDate() {
        return $this->repeatFinishDate;
    }

    function getDone() {
        return $this->done;
    }

    function getDoneDate() {
        return $this->doneDate;
    }

    function setDuration($duration) {
        $this->duration = $duration;
    }

    function setRepeatEnable($repeatEnable) {
        $this->repeatEnable = $repeatEnable;
    }

    function setRepeatBy($repeatBy) {
        $this->repeatBy = $repeatBy;
    }

    function setRepeatDay($repeatDay) {
        $this->repeatDay = $repeatDay;
    }

    function setRepeatEvery($repeatEvery) {
        $this->repeatEvery = $repeatEvery;
    }

    function setRepeatFinishDate(DateTime $repeatFinishDate) {
        $this->repeatFinishDate = $repeatFinishDate;
    }

    function setDone(Boolean $done) {
        $this->done = $done;
    }

    function setDoneDate(DateTime $doneDate) {
        $this->doneDate = $doneDate;
    }

}
