<?php

namespace CdiCalendar\Validator;

use Zend\Validator\AbstractValidator;

class Schedule extends \Zend\Validator\AbstractValidator {

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function setEntityManager(EntityManager $em) {
        $this->em = $em;
    }

    public function getEntityManager() {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

    function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    public function isValid($calendar, \DateTime $date = null) {
        $result = false;
        if (!$date) {
            $date = new \DateTime("now");
        }
        
        //Obtengo los schedules
        $query = $this->em->createQueryBuilder()
                ->select('u')
                ->from('CdiCalendar\Entity\Schedule', 'u', 'u.id')
                ->where('u.calendar = :calendar')
                ->setParameter("calendar", $calendar);

        $scheludes = $query->getQuery()->getResult();


        //reviso primero si hay un feriado
        $query = $this->em->createQueryBuilder()
                ->select('u')
                ->from('CdiCalendar\Entity\Holiday', 'u ')
                ->where('u.date = :date')
                ->setParameter("date", $date->format("Y-m-d"));

        $holiday = $query->getQuery()->getOneOrNullResult();

        //Si encuentro un feriado...
        if ($holiday) {
            if ($date->format("Hi") >= $scheludes[8]->getStartTime()->format("Hi") &&
                    $date->format("Hi") <= $scheludes[8]->getEndTime()->format("Hi")) {
                $result = true;
            }
        }

        //Si no hubo match en feriado verifico el dia..
        if (!$result) {
            foreach ($scheludes as $schelude) {

                if ($date->format("N") == $schelude->getDayOfWeek()->getId()) {
                   
                    if ($date->format("Hi") >= $schelude->getStartTime()->format("Hi") &&
                            $date->format("Hi") <= $schelude->getEndTime()->format("Hi")) {
                        $result = true;
                    }
                }
            }
        }

        return $result;
    }

}
