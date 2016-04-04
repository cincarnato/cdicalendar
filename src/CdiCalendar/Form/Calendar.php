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



    public function __construct() {


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

        $this->addSchedules();

        $this->addCsrf();
        $this->addSubmit();
    }

    protected function addSchedules() {
        $subForm = new \CdiCalendar\Form\Schedule();
        $subForm->setName("monday");
        $subForm->get('dayOfWeek')->setValue('1');
        $this->add($subForm);
        
         $subForm = new \CdiCalendar\Form\Schedule();
        $subForm->setName("tuesday");
          $subForm->get('dayOfWeek')->setValue('2');
        $this->add($subForm);
    }

    protected function addCsrf() {
        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf'
        ));
    }

    protected function addSubmit() {

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Cerrar'
            )
        ));
    }

    public function InputFilter() {

//        $inputFilter = new InputFilter();
//        $factory = new InputFactory();
//
//        return $inputFilter;
    }


}
