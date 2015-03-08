<?php

namespace CdiCalendar\Mapper;



class CalendarDoctrine extends \CdiCalendar\EventManager\EventProvider
{
    public function findAll() 
    {
        $er = $this->em->getRepository($this->options->getCalendarEntityClass());
        return $er->findAll();
    }

    
    public function remove($entity)
    {
        $this->getEventManager()->trigger('remove.pre', $this, array('entity' => $entity));
        $this->em->remove($entity);
        $this->em->flush();
        $this->getEventManager()->trigger('remove', $this, array('entity' => $entity));
    }
    
    public function insert($entity)
    {
        $this->getEventManager()->trigger('remove.pre', $this, array('entity' => $entity));
        $this->em->persist($entity);
        $this->em->flush();
        $this->getEventManager()->trigger('remove', $this, array('entity' => $entity));
    }
    
}
