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

    public function abmAction() {

        $grid = $this->getServiceLocator()->get('cdiGrid');
        $source = new \CdiDataGrid\DataGrid\Source\Doctrine($this->getEntityManager(), '\DBAL\Entity\WhatsappNumber');
        $grid->setSource($source);
        $grid->setRecordPerPage(20);
        $grid->datetimeColumn('createdAt', 'Y-m-d H:i:s');
        $grid->datetimeColumn('updatedAt', 'Y-m-d H:i:s');
        $grid->datetimeColumn('expiration', 'Y-m-d H:i:s');
        $grid->hiddenColumn('createdAt');
        $grid->hiddenColumn('updatedAt');
        $grid->hiddenColumn('createdBy');


        $grid->addExtraColumn("edit", "<a  class='fa fa-user btn btn-primary btn-xs' onclick='showProfile({{id}})' href='#'> Profile</a>      ", "right", false);

      
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
                var_dump($calendar);
            }
        }
        return array(
            'form' => $form,
        );
    }
}
