<?php

namespace CdiCalendar\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use CdiCommons\EventManager\EventProvider;
/**
 * Description of GoogleApiAnalytics
 *
 * @author cincarnato
 */
class Calendar extends EventProvider implements ServiceManagerAwareInterface{

    /**
     * @var UserMapperInterface
     */
    protected $calendarMapper;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @var \CdiCalendar\Options\CalendarOptionsInterface
     */
    protected $options;

    /**
     * @param Form $form
     * @param array $data
     * @return UserInterface|null
     */
    public function create(Form $form, array $data)
    {
        $zfcUserOptions = $this->getZfcUserOptions();
        $user = $form->getData();

        $argv = array();
        if ($this->getOptions()->getCreateUserAutoPassword()) {
            $argv['password'] = $this->generatePassword();
        } else {
            $argv['password'] = $user->getPassword();
        }
        $bcrypt = new Bcrypt;
        $bcrypt->setCost($zfcUserOptions->getPasswordCost());
        $user->setPassword($bcrypt->create($argv['password']));

        foreach ($this->getOptions()->getCreateFormElements() as $element) {
            call_user_func(array($user, $this->getAccessorName($element)), $data[$element]);
        }

        $argv += array('user' => $user, 'form' => $form, 'data' => $data);
        $this->getEventManager()->trigger(__FUNCTION__, $this, $argv);
        $this->getUserMapper()->insert($user);
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, $argv);
        return $user;
    }

    /**
     * @param Form $form
     * @param array $data
     * @param UserInterface $user
     * @return UserInterface
     */
    public function edit(Form $form, array $data, UserInterface $user)
    {
        // first, process all form fields
        foreach ($data as $key => $value) {
            if ($key == 'password') continue;

            $setter = $this->getAccessorName($key);
            if (method_exists($user, $setter)) call_user_func(array($user, $setter), $value);
        }

        $argv = array();
        // then check if admin wants to change user password
        if ($this->getOptions()->getAllowPasswordChange()) {
            if (!empty($data['reset_password'])) {
                $argv['password'] = $this->generatePassword();
            } elseif (!empty($data['password'])) {
                $argv['password'] = $data['password'];
            }

            if (!empty($argv['password'])) {
                $bcrypt = new Bcrypt();
                $bcrypt->setCost($this->getZfcUserOptions()->getPasswordCost());
                $user->setPassword($bcrypt->create($argv['password']));
            }
        }

        // TODO: not sure if this code is required here - all fields that came from the form already saved
        foreach ($this->getOptions()->getEditFormElements() as $element) {
            call_user_func(array($user, $this->getAccessorName($element)), $data[$element]);
        }

        $argv += array('user' => $user, 'form' => $form, 'data' => $data);
        $this->getEventManager()->trigger(__FUNCTION__, $this, $argv);
        $this->getUserMapper()->update($user);
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, $argv);
        return $user;
    }

    
    
    public function getCalendarMapper()
    {
        if (null === $this->calendarMapper) {
            $this->calendarMapper = $this->getServiceManager()->get('cdicalendar_calendar_mapper');
        }
        return $this->calendarMapper;
    }

    public function setUserMapper(CalendarMapperInterface $calendarMapper)
    {
        $this->calendarMapper = $calendarMapper;
        return $this;
    }

    public function setOptions(ModuleOptions $options)
    {
        $this->options = $options;
        return $this;
    }

    public function getOptions()
    {
        if (!$this->options instanceof ModuleOptions) {
            $this->setOptions($this->getServiceManager()->get('cdicalendar_options'));
        }
        return $this->options;
    }

   

    /**
     * Retrieve service manager instance
     *
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * Set service manager instance
     *
     * @param ServiceManager $serviceManager
     * @return User
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }
 

}

?>
