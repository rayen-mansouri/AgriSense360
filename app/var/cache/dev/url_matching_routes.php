<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/' => [[['_route' => 'intro', '_controller' => 'App\\Controller\\AuthController::intro'], null, ['GET' => 0], null, false, false, null]],
        '/auth/login' => [[['_route' => 'auth_login', '_controller' => 'App\\Controller\\AuthController::login'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/auth/signup' => [[['_route' => 'auth_signup', '_controller' => 'App\\Controller\\AuthController::signup'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/logout' => [[['_route' => 'auth_logout', '_controller' => 'App\\Controller\\AuthController::logout'], null, ['GET' => 0], null, false, false, null]],
        '/equipment' => [[['_route' => 'equipment_index', '_controller' => 'App\\Controller\\EquipmentController::index'], null, ['GET' => 0], null, true, false, null]],
        '/equipment/new' => [[['_route' => 'equipment_new', '_controller' => 'App\\Controller\\EquipmentController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/home' => [[['_route' => 'home', '_controller' => 'App\\Controller\\HomeController::index'], null, null, null, false, false, null]],
        '/admin/home' => [[['_route' => 'admin_home', '_controller' => 'App\\Controller\\HomeController::admin'], null, null, null, false, false, null]],
        '/management/animals' => [[['_route' => 'management_animals', '_controller' => 'App\\Controller\\ManagementController::animals'], null, null, null, false, false, null]],
        '/admin/management/animals' => [[['_route' => 'admin_management_animals', '_controller' => 'App\\Controller\\ManagementController::adminAnimals'], null, null, null, false, false, null]],
        '/management/equipments' => [[['_route' => 'management_equipments', '_controller' => 'App\\Controller\\ManagementController::equipments'], null, null, null, false, false, null]],
        '/admin/management/equipments' => [[['_route' => 'admin_management_equipments', '_controller' => 'App\\Controller\\ManagementController::adminEquipments'], null, null, null, false, false, null]],
        '/management/stock' => [[['_route' => 'management_stock', '_controller' => 'App\\Controller\\ManagementController::stock'], null, null, null, false, false, null]],
        '/admin/management/stock' => [[['_route' => 'admin_management_stock', '_controller' => 'App\\Controller\\ManagementController::adminStock'], null, null, null, false, false, null]],
        '/management/culture' => [[['_route' => 'management_culture', '_controller' => 'App\\Controller\\ManagementController::culture'], null, null, null, false, false, null]],
        '/admin/management/culture' => [[['_route' => 'admin_management_culture', '_controller' => 'App\\Controller\\ManagementController::adminCulture'], null, null, null, false, false, null]],
        '/management/users' => [[['_route' => 'management_users', '_controller' => 'App\\Controller\\ManagementController::users'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/admin/management/users' => [[['_route' => 'admin_management_users', '_controller' => 'App\\Controller\\ManagementController::adminUsers'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/management/workers' => [[['_route' => 'management_workers', '_controller' => 'App\\Controller\\ManagementController::workers'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/admin/management/workers' => [[['_route' => 'admin_management_workers', '_controller' => 'App\\Controller\\ManagementController::adminWorkers'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
                .'|/equipment/([^/]++)(?'
                    .'|(*:64)'
                    .'|/edit(*:76)'
                    .'|(*:83)'
                .')'
                .'|/management/(?'
                    .'|equipments/(?'
                        .'|([^/]++)/(?'
                            .'|edit(*:136)'
                            .'|delete(*:150)'
                        .')'
                        .'|maintenance/([^/]++)/(?'
                            .'|edit(*:187)'
                            .'|delete(*:201)'
                        .')'
                    .')'
                    .'|workers/(?'
                        .'|([^/]++)/(?'
                            .'|edit(*:238)'
                            .'|delete(*:252)'
                        .')'
                        .'|evaluation/([^/]++)/(?'
                            .'|edit(*:288)'
                            .'|delete(*:302)'
                        .')'
                    .')'
                .')'
                .'|/admin/management/(?'
                    .'|equipments/(?'
                        .'|([^/]++)/(?'
                            .'|edit(*:364)'
                            .'|delete(*:378)'
                        .')'
                        .'|maintenance/([^/]++)/(?'
                            .'|edit(*:415)'
                            .'|delete(*:429)'
                        .')'
                    .')'
                    .'|workers/(?'
                        .'|([^/]++)/(?'
                            .'|edit(*:466)'
                            .'|delete(*:480)'
                        .')'
                        .'|evaluation/([^/]++)/(?'
                            .'|edit(*:516)'
                            .'|delete(*:530)'
                        .')'
                    .')'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        64 => [[['_route' => 'equipment_show', '_controller' => 'App\\Controller\\EquipmentController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        76 => [[['_route' => 'equipment_edit', '_controller' => 'App\\Controller\\EquipmentController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        83 => [[['_route' => 'equipment_delete', '_controller' => 'App\\Controller\\EquipmentController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        136 => [[['_route' => 'management_equipments_edit', '_controller' => 'App\\Controller\\ManagementController::editEquipment'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        150 => [[['_route' => 'management_equipments_delete', '_controller' => 'App\\Controller\\ManagementController::deleteEquipment'], ['id'], ['POST' => 0], null, false, false, null]],
        187 => [[['_route' => 'management_maintenance_edit', '_controller' => 'App\\Controller\\ManagementController::editMaintenance'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        201 => [[['_route' => 'management_maintenance_delete', '_controller' => 'App\\Controller\\ManagementController::deleteMaintenance'], ['id'], ['POST' => 0], null, false, false, null]],
        238 => [[['_route' => 'management_workers_edit', '_controller' => 'App\\Controller\\ManagementController::editWorker'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        252 => [[['_route' => 'management_workers_delete', '_controller' => 'App\\Controller\\ManagementController::deleteWorker'], ['id'], ['POST' => 0], null, false, false, null]],
        288 => [[['_route' => 'management_evaluation_edit', '_controller' => 'App\\Controller\\ManagementController::editEvaluation'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        302 => [[['_route' => 'management_evaluation_delete', '_controller' => 'App\\Controller\\ManagementController::deleteEvaluation'], ['id'], ['POST' => 0], null, false, false, null]],
        364 => [[['_route' => 'admin_management_equipments_edit', '_controller' => 'App\\Controller\\ManagementController::adminEditEquipment'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        378 => [[['_route' => 'admin_management_equipments_delete', '_controller' => 'App\\Controller\\ManagementController::adminDeleteEquipment'], ['id'], ['POST' => 0], null, false, false, null]],
        415 => [[['_route' => 'admin_management_maintenance_edit', '_controller' => 'App\\Controller\\ManagementController::adminEditMaintenance'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        429 => [[['_route' => 'admin_management_maintenance_delete', '_controller' => 'App\\Controller\\ManagementController::adminDeleteMaintenance'], ['id'], ['POST' => 0], null, false, false, null]],
        466 => [[['_route' => 'admin_management_workers_edit', '_controller' => 'App\\Controller\\ManagementController::adminEditWorker'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        480 => [[['_route' => 'admin_management_workers_delete', '_controller' => 'App\\Controller\\ManagementController::adminDeleteWorker'], ['id'], ['POST' => 0], null, false, false, null]],
        516 => [[['_route' => 'admin_management_evaluation_edit', '_controller' => 'App\\Controller\\ManagementController::adminEditEvaluation'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        530 => [
            [['_route' => 'admin_management_evaluation_delete', '_controller' => 'App\\Controller\\ManagementController::adminDeleteEvaluation'], ['id'], ['POST' => 0], null, false, false, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
