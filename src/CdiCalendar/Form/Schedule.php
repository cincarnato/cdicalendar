<?php

namespace CdiCalendar\Form;

use Zend\Form\Form,
    Doctrine\Common\Persistence\ObjectManager,
    DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator,
    Zend\Form\Annotation\AnnotationBuilder;
use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Doctrine\ORM\EntityManager;
use Zend\Form\Fieldset;

class Schedule extends Fieldset  {


    public function __construct($em) {


        parent::__construct('scheduleForm');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', "form-horizontal");
        $this->setAttribute('role', "form");
        
         $this
             ->setHydrator(new DoctrineHydrator($em))
             ->setObject(new \CdiCalendar\Entity\Schedule())
         ;
        
        
        /*
         * Input hidden
         */
        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        /*
         * Calendar
         */
        $this->add(array(
            'name' => 'calendar',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        /*
         * Day Of Week
         */
        $this->add(array(
            'name' => 'dayOfWeek',
            'type' => 'Zend\Form\Element\Hidden',
        ));


        $this->add(array(
            'name' => 'startTime',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'required' => true,
                'class' => "form-control",
                'placeholder' => "StartTime",
                'value' => '00:00'
            ),
            'options' => array(
                'label' => 'StartTime',
            )
        ));

        $this->add(array(
            'name' => 'endTime',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'required' => true,
                'class' => "form-control",
                'placeholder' => "EndTime",
                  'value' => '00:00'
            ),
            'options' => array(
                'label' => 'EndTime',
            )
        ));



        $this->addSubmit();
    }

    protected function addSchedules() {
        
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

        $inputFilter = new InputFilter();
        $factory = new InputFactory();
        $inputFilter->add($factory->createInput(array(
                    'name' => 'startTime',
                    'required' => true,
                    'validators' => array(
                        array(
                            'name' => 'regex',
                            'options' => array(
                                'pattern' => "/^[0-6][0-9]:[0-6][0-9]$/",
                            ),
                        ),
                    ),
        )));

        $inputFilter->add($factory->createInput(array(
                    'name' => 'endTime',
                    'required' => true,
                    'validators' => array(
                        array(
                            'name' => 'regex',
                            'options' => array(
                                'pattern' => "/^[0-6][0-9]:[0-6][0-9]$/",
                            ),
                        ),
                    ),
        )));

        return $inputFilter;
    }


}
