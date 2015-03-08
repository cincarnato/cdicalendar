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
    
    public function addMin(){
        
         /*
         * Input Text
         */
        $this->add(array(
            'name' => 'title',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'required' => false,
                'class' => "form-control",
                'placeholder' => "xxx"
            ),
            'options' => array(
                'label' => 'Titulo',
                'description' => ''
            )
        ));
        
        /*
         * Input TextArea
         */
        $this->add(array(
            'name' => 'description',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'required' => false,
                'class' => "form-control",
            ),
            'options' => array(
                'label' => 'Descripcion',
                'description' => ''
            )
        ));
        
        
        /*
         * Input Date
         */

        $this->add(array(
            'name' => 'scheduleDate',
            'type' => 'Zend\Form\Element\Date',
            'attributes' => array(
                'required' => false,
             'class' => "form-control",
                  'data-date-format' => 'YYYY/MM/DD HH:II:SS',
            ),
            'options' => array(
                'label' => 'Fecha Y Hora',
                'description' => ''
            )
        ));
        
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
