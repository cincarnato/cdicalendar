<?php

namespace CdiCalendar\Controller;

use Zend\Mvc\Controller\AbstractActionController;
//use Zend\Paginator;
//use Zend\Stdlib\Hydrator\ClassMethods;
use CdiCalendar\Options\ModuleOptions;

class CalendarController extends AbstractActionController {

    protected $options;
    protected $calendarMapper;
    protected $cdiCalendarOptions;

    /**
     * @var \CdiCalendar\Service\Calendar
     */
    protected $calendarService;

    public function listAction() {
        $calendarMapper = $this->getCalendarMapper();
        $users = $calendarMapper->findAll();
        if (is_array($users)) {
            $paginator = new Paginator\Paginator(new Paginator\Adapter\ArrayAdapter($users));
        } else {
            $paginator = $users;
        }

        $paginator->setItemCountPerPage(100);
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('p'));
        return array(
            'calendars' => $paginator,
            'calendarslistElements' => $this->getOptions()->getUserListElements()
        );
    }

    public function createAction() {
        /** @var $form \ZfcUserAdmin\Form\CreateUser */
        $form = $this->getServiceLocator()->get('zfcuseradmin_createuser_form');
        $request = $this->getRequest();

        /** @var $request \Zend\Http\Request */
        if ($request->isPost()) {


            $zfcUserOptions = $this->getZfcUserOptions();
            $class = $zfcUserOptions->getUserEntityClass();
            $user = new $class();
            //$form->setHydrator(new ClassMethods());
            $form->bind($user);
            $form->setData($request->getPost());

            if ($form->isValid()) {


                $user = $this->getAdminUserService()->create($form, (array) $request->getPost());
                //var_dump($user);
                if ($user) {
                    $this->flashMessenger()->addSuccessMessage('The user was created');
                    return $this->redirect()->toRoute('zfcadmin/zfcuseradmin/list');
                }
            }
        }

        return array(
            'createUserForm' => $form
        );
    }

    public function editAction() {
        $userId = $this->getEvent()->getRouteMatch()->getParam('userId');
        $user = $this->getCalendarMapper()->findById($userId);

        /** @var $form \ZfcUserAdmin\Form\EditUser */
        $form = $this->getServiceLocator()->get('zfcuseradmin_edituser_form');
        $form->setUser($user);

        //Si se pone el bind, levanta la password en el form y es un problema
        //$form->bind($user);


        /** @var $request \Zend\Http\Request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {


                //Provisiorio. Se debe mover. (Parche)     
                $role = $this->getEntityManager()->find("CdiUser\Entity\Role", $this->params()->fromPost('rol'));
                $user->setRoles($role);

                $user = $this->getAdminUserService()->edit($form, (array) $request->getPost(), $user);

                if ($user) {
                    $this->flashMessenger()->addSuccessMessage('The user was edited');
                    return $this->redirect()->toRoute('zfcadmin/zfcuseradmin/list');
                }
            }
        } else {

            $form->populateFromUser($user);
            //Parche para mostrar el rol adeacuado
            $form->get('rol')->setValue($user->getRoles()->getId());
        }

        return array(
            'editUserForm' => $form,
            'userId' => $userId
        );
    }

    public function removeAction() {
        $userId = $this->getEvent()->getRouteMatch()->getParam('userId');

        /** @var $identity \ZfcUser\Entity\UserInterface */
        $identity = $this->zfcUserAuthentication()->getIdentity();
        if ($identity && $identity->getId() == $userId) {
            $this->flashMessenger()->addErrorMessage('You can not delete yourself');
        } else {
            $user = $this->getCalendarMapper()->findById($userId);
            if ($user) {
                $this->getCalendarMapper()->remove($user);
                $this->flashMessenger()->addSuccessMessage('The user was deleted');
            }
        }

        return $this->redirect()->toRoute('zfcadmin/zfcuseradmin/list');
    }

   
    public function setOptions(ModuleOptions $options) {
        $this->options = $options;
        return $this;
    }

    public function getOptions() {
        if (!$this->options instanceof ModuleOptions) {
            $this->setOptions($this->getServiceLocator()->get('cdicalendar_module_options'));
        }
        return $this->options;
    }

    public function getCalendarMapper() {
        if (null === $this->calendarMapper) {
            $this->calendarMapper = $this->getServiceLocator()->get('zfcuser_user_mapper');
        }
        return $this->calendarMapper;
    }

    public function setCalendarMapper(UserInterface $calendarMapper) {
        $this->calendarMapper = $calendarMapper;
        return $this;
    }

    public function getCalendarService() {
        if (null === $this->calendarService) {
            $this->calendarService = $this->getServiceLocator()->get('cdicalendar_calendar_service');
        }
        return $this->calendarService;
    }

    public function setCalendarService($service) {
        $this->calendarService = $service;
        return $this;
    }

}
