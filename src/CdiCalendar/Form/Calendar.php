<?php

namespace CdiCalendar\Form;

use Zend\Form\Form,
    Doctrine\Common\Persistence\ObjectManager,
    DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator,
    Zend\Form\Annotation\AnnotationBuilder;
use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Doctrine\ORM\EntityManager;

class Calendar extends \CdiCommons\Form\BaseForm {

    protected $serviceManager;


    public function __construct($serviceManager) {
        
        
        parent::__construct('CalendarForm');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', "form-horizontal");
        $this->setAttribute('role', "form");
        /*
         * Input hidden
         */
        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));



        $this->addCsrf();
        $this->addSubmit();
    }

    public function InputFilter() {

//        $inputFilter = new InputFilter();
//        $factory = new InputFactory();
//
//        return $inputFilter;
    }
    
    function getServiceManager() {
        return $this->serviceManager;
    }

    function setServiceManager($serviceManager) {
        $this->serviceManager = $serviceManager;
    }



}
