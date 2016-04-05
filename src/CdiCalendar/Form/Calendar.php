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

    public function __construct($em) {


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

        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'required' => true,
                'class' => "form-control",
                'placeholder' => "Name",
            ),
            'options' => array(
                'label' => 'Name',
            )
        ));

        $this->addSchedules($em);

        $this->addCsrf();
        $this->addSubmit();
        $this->get('submit')->setAttribute("class","btn btn-success");
    }

    protected function addSchedules($em) {

        $colDayOfWeek = $em->getRepository('CdiCalendar\Entity\DayOfWeek')->findAll();
        foreach ($colDayOfWeek as $dayOfWeek) {
            $subForm = new \CdiCalendar\Form\Schedule($em);
            $subForm->setName($dayOfWeek->getName());
            $subForm->get('dayOfWeek')->setValue($dayOfWeek->getId());
            $this->add($subForm);
        }
    }

    public
            function InputFilter() {

//        $inputFilter = new InputFilter();
//        $factory = new InputFactory();
//
//        return $inputFilter;
    }

}
