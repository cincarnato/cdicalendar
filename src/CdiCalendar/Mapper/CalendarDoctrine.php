<?php

namespace CdiCalendar\Mapper;

use Doctrine\ORM\EntityManager;
use CdiCalendar\Options\CalendarOptions;

class CalendarDoctrine 
extends \CdiCommons\EventManager\EventProvider 
implements \CdiCalendar\Mapper\CalendarInterface
 {
    
      /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \ZfcUserDoctrineORM\Options\ModuleOptions
     */
    protected $options;
    
       public function __construct(EntityManager $em, CalendarOptions $options)
    {
        $this->em      = $em;
        $this->options = $options;
    }


    public function findAll() 
    {
        $er = $this->em->getRepository($this->options->getCalendarEntityClass());
        return $er->findAll();
    }
    
     public function findById($id )
    {
        $er = $this->em->getRepository($this->options->getCalendarEntityClass());
        return $er->findBy($id);
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
        $this->getEventManager()->trigger('insert.pre', $this, array('entity' => $entity));
        $this->em->persist($entity);
        $this->em->flush();
        $this->getEventManager()->trigger('insert', $this, array('entity' => $entity));
    }
    
    public function update($entity)
    {
        $this->getEventManager()->trigger('update.pre', $this, array('entity' => $entity));
        $this->em->persist($entity);
        $this->em->flush();
        $this->getEventManager()->trigger('update', $this, array('entity' => $entity));
        return $entity;
    }
    
}
