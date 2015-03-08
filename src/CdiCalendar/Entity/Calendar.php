<?php

namespace CdiCalendar\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * An example of how to implement a role aware user entity.
 *
 * @ORM\Entity
 * @ORM\Table(name="threads")
 *
 * @author Cristian Incarnato
 */
class Calendar extends ExtendedEntity {


    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * 
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
     * @var integer
     * @ORM\Column(type="datetime", unique=false, nullable=true, name="schedule_date")
     */
    protected $scheduledDate;
    
    
    


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


 

}

