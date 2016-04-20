<?php

/**
 * TITLE
 *
 * Description
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 *
 * @package Paquete
 */

namespace CdiCalendar\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * Easily export data to downloadable CSV files.
 */
class OnSchedule extends AbstractPlugin {

    /**
     * @param DateTime $date
     * @param \CdiCalendar\Entity\Calendar  $calendar
     *
     * @return true|false
     */
    public function __invoke(\CdiCalendar\Entity\Calendar $calendar, Doctrine\ORM\EntityManager $em) {
        $result = false;
        $date = new \DateTime("now");

        //Obtengo los schedules
        $query = $em->createQueryBuilder()
                ->select('u')
                ->from('CdiCalendar\Entity\Schedule', 'u', 'u.id')
                ->where('u.calendar = :calendar')
                ->setParameter("calendar", $calendar);

        $scheludes = $query->getQuery()->getOneOrNullResult();


        //reviso primero si hay un feriado
        $query = $em->createQueryBuilder()
                ->select('u')
                ->from('CdiCalendar\Entity\Holiday', 'u ')
                ->where('u.date = :date')
                ->setParameter("date", $date->format("Y-m-d"));

        $holiday = $query->getQuery()->getOneOrNullResult();

        if ($holiday) {
            if ($date->format("Hi") >= $scheludes[8]->getStartTime()->format("Hi") &&
                    $date->format("Hi") <= $scheludes[8]->getEndTime()->format("Hi")) {
                $result = true;
            }
        }

        //Si aun result no es true verico el dia
        if (!$result) {
            foreach ($scheludes as $schelude) {

                if ($date->format("N") == $schelude->getId()) {
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
