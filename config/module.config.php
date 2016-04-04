<?php

return array(
     'view_manager' => array(
        'template_path_stack' => array(
            'cdicalendar' => __DIR__ . '/../view',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'cdicalendar' => 'CdiCalendar\Controller\CalendarController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'zfcadmin' => array(
                'child_routes' => array(
                    'zfcuseradmin' => array(
                        'type' => 'Literal',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/calendar',
                            'defaults' => array(
                                'controller' => 'cdicalendar',
                                'action'     => 'index',
                            ),
                        ),
                        'child_routes' =>array(
                            'list' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/list[/:p]',
                                    'defaults' => array(
                                        'controller' => 'zfcuseradmin',
                                        'action'     => 'list',
                                    ),
                                ),
                            ),
                            'create' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/create',
                                    'defaults' => array(
                                        'controller' => 'zfcuseradmin',
                                        'action'     => 'create'
                                    ),
                                ),
                            ),
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/edit/:calendarId',
                                    'defaults' => array(
                                        'controller' => 'zfcuseradmin',
                                        'action'     => 'edit',
                                        'userId'     => 0
                                    ),
                                ),
                            ),
                            'remove' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/remove/:calendarId',
                                    'defaults' => array(
                                        'controller' => 'zfcuseradmin',
                                        'action'     => 'remove',
                                        'userId'     => 0
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
      'doctrine' => array(
        'driver' => array(
            'cdicalendar_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/CdiCalendar/Entity',
            ),
            'orm_default' => array(
                'drivers' => array(
                    'CdiCalendar\Entity' => 'cdicalendar_entity',
                ),
            ),
        ),
    ),
    
    'cdicalendar_options' => array(
        'calendarEntityClass' => 'CdiCalendar/Entity/Calendar',
    )
);
