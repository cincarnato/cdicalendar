<?php

namespace CdiCalendar\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CalendarController extends AbstractActionController {

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

    public function holidayAction() {

        $grid = $this->getServiceLocator()->get('cdiGrid');
        $source = new \CdiDataGrid\DataGrid\Source\Doctrine($this->getEntityManager(), '\CdiCalendar\Entity\Holiday');
        $grid->setSource($source);
        $grid->setRecordPerPage(20);
        $grid->datetimeColumn('createdAt', 'Y-m-d H:i:s');
        $grid->datetimeColumn('updatedAt', 'Y-m-d H:i:s');
        $grid->datetimeColumn('date', 'Y-m-d');
        $grid->hiddenColumn('createdAt');
        $grid->hiddenColumn('updatedAt');
        $grid->hiddenColumn('createdBy');


        $grid->addDelOption("Del", "left", "btn btn-warning fa fa-trash");
        $grid->addNewOption("Add", "btn btn-primary fa fa-plus", " Agregar");
        $grid->addEditOption("Edit", "left", "btn btn-primary fa fa-edit");
        $grid->setTableClass("table-condensed customClass");
        $grid->prepare();
        return array('grid' => $grid);
    }

    public function abmAction() {

        $grid = $this->getServiceLocator()->get('cdiGrid');
        $source = new \CdiDataGrid\DataGrid\Source\Doctrine($this->getEntityManager(), '\CdiCalendar\Entity\Calendar');
        $grid->setSource($source);
        $grid->setRecordPerPage(20);
        $grid->datetimeColumn('createdAt', 'Y-m-d H:i:s');
        $grid->datetimeColumn('updatedAt', 'Y-m-d H:i:s');

        $grid->hiddenColumn('createdAt');
        $grid->hiddenColumn('updatedAt');
        $grid->hiddenColumn('createdBy');
        $grid->hiddenColumn('schedule');


        $grid->addExtraColumn("Edit", "<a  class='btn btn-primary fa fa-edit' href='/cdicalendar/edit/{{id}}'></a>      ", "left", false);


        $grid->addDelOption("Del", "left", "btn btn-warning fa fa-trash");
//        $grid->addNewOption("Add", "btn btn-primary fa fa-plus", " Agregar");
        $grid->setTableClass("table-condensed customClass");
        $grid->prepare();
        return array('grid' => $grid);
    }

    public function newAction() {




        $form = new \CdiCalendar\Form\Calendar($this->getEntityManager());
        $calendar = new \CdiCalendar\Entity\Calendar();
        $form->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->getEntityManager()));
        $form->bind($calendar);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {

                foreach ($form->getFieldsets() as $fieldset) {
                    $object = $fieldset->getObject();
                    $calendar->addSchedule($object);
                    $object->setCalendar($calendar);
                }

                try {
                    $this->getEntityManager()->persist($calendar);
                    $this->getEntityManager()->flush();
                    $this->flashMessenger()->addSuccessMessage('Se creo correctamente el calendario. ID:' . $calendar->getId() . "");
                    return $this->redirect()->toRoute('cdicalendar', array('controller' => "CdiCalendar\Controller\Calendar",
                                'action' => "abm"));
                } catch (Exception $ex) {
                    return $this->redirect()->toRoute('cdierror', array('controller' => "CdiCommons\Controller\Error",
                                'action' => "db", 'error' => $ex));
                }
            } else {
                
            }
        }
        return array(
            'form' => $form,
        );
    }

    public function editAction() {
        $calendarId = $this->params("id");
        $form = new \CdiCalendar\Form\Calendar($this->getEntityManager());

        $calendar = $this->getEntityManager()->getRepository('CdiCalendar\Entity\Calendar')->find($calendarId);
        $form->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->getEntityManager()));

        foreach ($calendar->getSchedule() as $schedule) {
            $form->get($schedule->getDayOfWeek()->getName())->get('id')->setValue($schedule->getId());
            $form->get($schedule->getDayOfWeek()->getName())->get('calendar')->setValue($calendarId);
            $form->get($schedule->getDayOfWeek()->getName())->get('startTime')->setValue($schedule->getStartTime()->format("H:i"));
            $form->get($schedule->getDayOfWeek()->getName())->get('endTime')->setValue($schedule->getEndTime()->format("H:i"));
        }

        $form->bind($calendar);




        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {

                foreach ($form->getFieldsets() as $fieldset) {
                    $object = $fieldset->getObject();
                    $calendar->addSchedule($object);
                    $object->setCalendar($calendar);
                }
                try {
                    $this->getEntityManager()->persist($calendar);
                    $this->getEntityManager()->flush();
                    $this->flashMessenger()->addSuccessMessage('Se actualizo el calendarioID:' . $calendar->getId() . "");
                    return $this->redirect()->toRoute('cdicalendar', array('controller' => "CdiCalendar\Controller\Calendar",
                                'action' => "abm"));
                } catch (Exception $ex) {
                    return $this->redirect()->toRoute('cdierror', array('controller' => "CdiCommons\Controller\Error",
                                'action' => "db", 'error' => $ex));
                }
            } else {
                
            }
        }
        return array(
            'form' => $form,
        );
    }

}
